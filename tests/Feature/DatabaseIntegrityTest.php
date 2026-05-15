<?php

namespace Tests\Feature;

use App\Models\Commentaire;
use App\Models\Message;
use App\Models\Property;
use App\Models\Reclamation;
use App\Models\Ressource;
use App\Models\Image;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;

class DatabaseIntegrityTest extends TestCase
{
    use RefreshDatabase;

    private function makeProperty(User $user): Property
    {
        return Property::create([
            'user_id'          => $user->id,
            'title'            => 'Bien Intégrité',
            'description'      => 'Test',
            'price'            => 200000,
            'type_transaction' => 'vente',
            'type_bien'        => 'maison',
            'surface'          => 90,
            'city'             => 'Safi',
            'address'          => '1 rue Test',
            'phone'            => '0600000000',
            'status'           => 'publiee',
            'is_approved'      => true,
        ]);
    }

    // ─── Schema ─────────────────────────────────────────────────────────────

    /** @test */
    public function users_table_has_required_columns()
    {
        $required = ['id', 'name', 'email', 'password', 'is_admin', 'is_active', 'created_at'];
        foreach ($required as $col) {
            $this->assertTrue(Schema::hasColumn('users', $col), "Column [$col] missing from users table");
        }
    }

    /** @test */
    public function properties_table_has_required_columns()
    {
        $required = [
            'id', 'user_id', 'title', 'description', 'price',
            'type_transaction', 'type_bien', 'surface', 'rooms',
            'city', 'address', 'phone', 'status',
            'is_approved', 'approved_at', 'views_count',
            'latitude', 'longitude', 'created_at',
        ];
        foreach ($required as $col) {
            $this->assertTrue(Schema::hasColumn('properties', $col), "Column [$col] missing from properties table");
        }
    }

    /** @test */
    public function commentaires_table_has_required_columns()
    {
        $required = ['id', 'property_id', 'user_id', 'guest_name', 'content', 'is_approved'];
        foreach ($required as $col) {
            $this->assertTrue(Schema::hasColumn('commentaires', $col), "Column [$col] missing from commentaires table");
        }
    }

    /** @test */
    public function messages_table_has_required_columns()
    {
        $required = ['id', 'property_id', 'receiver_id', 'visitor_name', 'visitor_email', 'content', 'is_read'];
        foreach ($required as $col) {
            $this->assertTrue(Schema::hasColumn('messages', $col), "Column [$col] missing from messages table");
        }
    }

    /** @test */
    public function reclamations_table_has_required_columns()
    {
        $required = ['id', 'user_id', 'subject', 'message', 'priority', 'status', 'is_read'];
        foreach ($required as $col) {
            $this->assertTrue(Schema::hasColumn('reclamations', $col), "Column [$col] missing from reclamations table");
        }
    }

    /** @test */
    public function ressources_table_has_required_columns()
    {
        $required = ['id', 'property_id', 'resourceable_type', 'resourceable_id'];
        foreach ($required as $col) {
            $this->assertTrue(Schema::hasColumn('ressources', $col), "Column [$col] missing from ressources table");
        }
    }

    // ─── Cascade on delete ──────────────────────────────────────────────────

    /** @test */
    public function deleting_user_cascades_to_properties()
    {
        $user     = User::factory()->create();
        $property = $this->makeProperty($user);
        $propId   = $property->id;

        $user->delete();

        $this->assertDatabaseMissing('properties', ['id' => $propId]);
    }

    /** @test */
    public function deleting_property_cascades_to_commentaires()
    {
        $user     = User::factory()->create();
        $property = $this->makeProperty($user);

        Commentaire::create([
            'property_id' => $property->id,
            'content'     => 'Commentaire sur ce bien',
            'is_approved' => false,
        ]);

        $propId = $property->id;
        $property->delete();

        $this->assertDatabaseMissing('commentaires', ['property_id' => $propId]);
    }

    /** @test */
    public function deleting_property_cascades_to_messages()
    {
        $user     = User::factory()->create();
        $property = $this->makeProperty($user);

        Message::create([
            'property_id'   => $property->id,
            'receiver_id'   => $user->id,
            'visitor_name'  => 'Test',
            'visitor_email' => 'test@test.com',
            'content'       => 'Message de test',
            'is_read'       => false,
        ]);

        $propId = $property->id;
        $property->delete();

        $this->assertDatabaseMissing('messages', ['property_id' => $propId]);
    }

    /** @test */
    public function deleting_property_cascades_to_ressources()
    {
        $user     = User::factory()->create();
        $property = $this->makeProperty($user);

        $image = Image::create(['path' => 'properties/images/test.jpg']);
        Ressource::create([
            'property_id'       => $property->id,
            'resourceable_type' => Image::class,
            'resourceable_id'   => $image->id,
        ]);

        $propId = $property->id;
        $property->delete();

        $this->assertDatabaseMissing('ressources', ['property_id' => $propId]);
    }

    /** @test */
    public function deleting_user_cascades_to_reclamations()
    {
        $user = User::factory()->create();

        Reclamation::create([
            'user_id'  => $user->id,
            'subject'  => 'Réclamation test',
            'message'  => 'Message de test',
            'priority' => 'normale',
            'status'   => 'ouvert',
            'is_read'  => false,
        ]);

        $userId = $user->id;
        $user->delete();

        $this->assertDatabaseMissing('reclamations', ['user_id' => $userId]);
    }

    // ─── Middleware admin ────────────────────────────────────────────────────

    /** @test */
    public function non_admin_user_is_redirected_from_admin_routes()
    {
        $user     = User::factory()->create(['is_admin' => false]);
        $response = $this->actingAs($user)->get(route('admin.dashboard'));
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function unauthenticated_user_is_redirected_from_protected_routes()
    {
        foreach ([
            route('dashboard.index'),
            route('dashboard.my-properties'),
            route('messages.index'),
            route('reclamations.create'),
            route('profile.edit'),
        ] as $url) {
            $this->get($url)->assertRedirect(route('login'));
        }
    }

    // ─── Email unique ────────────────────────────────────────────────────────

    /** @test */
    public function two_users_cannot_have_the_same_email()
    {
        User::factory()->create(['email' => 'dupliquer@example.com']);

        $response = $this->post(route('register'), [
            'name'                  => 'Copie',
            'email'                 => 'dupliquer@example.com',
            'password'              => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);

        $response->assertSessionHasErrors(['email']);
        $this->assertDatabaseCount('users', 1);
    }

    // ─── Ressource polymorphique ─────────────────────────────────────────────

    /** @test */
    public function ressource_polymorphic_relation_resolves_correctly()
    {
        $user     = User::factory()->create();
        $property = $this->makeProperty($user);

        $image = Image::create(['path' => 'properties/images/poly_test.jpg']);
        $res   = Ressource::create([
            'property_id'       => $property->id,
            'resourceable_type' => Image::class,
            'resourceable_id'   => $image->id,
        ]);

        $this->assertInstanceOf(Image::class, $res->resourceable);
        $this->assertEquals($image->id, $res->resourceable->id);
    }
}
