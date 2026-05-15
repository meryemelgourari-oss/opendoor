<?php

namespace Tests\Unit;

use App\Models\Property;
use App\Models\User;
use App\Models\Ressource;
use App\Models\Commentaire;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PropertyModelTest extends TestCase
{
    use RefreshDatabase;

    // ─── Attributs & Casts ──────────────────────────────────────────────────

    /** @test */
    public function price_is_cast_to_decimal()
    {
        $user = User::factory()->create();
        $property = Property::create([
            'user_id'          => $user->id,
            'title'            => 'Test',
            'description'      => 'Desc',
            'price'            => 150000,
            'type_transaction' => 'vente',
            'type_bien'        => 'maison',
            'surface'          => 100,
            'city'             => 'Safi',
            'address'          => '1 rue Test',
            'phone'            => '0600000000',
            'status'           => 'publiee',
        ]);

        $this->assertIsFloat((float) $property->price);
        $this->assertEquals(150000, $property->price);
    }

    /** @test */
    public function is_approved_is_cast_to_boolean()
    {
        $user = User::factory()->create();
        $property = Property::create([
            'user_id'          => $user->id,
            'title'            => 'Test',
            'description'      => 'Desc',
            'price'            => 1000,
            'type_transaction' => 'location',
            'type_bien'        => 'appartement',
            'surface'          => 50,
            'city'             => 'Safi',
            'address'          => '1 rue Test',
            'phone'            => '0600000000',
            'status'           => 'publiee',
            'is_approved'      => 1,
        ]);

        $this->assertIsBool($property->is_approved);
        $this->assertTrue($property->is_approved);
    }

    /** @test */
    public function views_count_is_cast_to_integer()
    {
        $user = User::factory()->create();
        $property = Property::create([
            'user_id'          => $user->id,
            'title'            => 'Test',
            'description'      => 'Desc',
            'price'            => 1000,
            'type_transaction' => 'location',
            'type_bien'        => 'appartement',
            'surface'          => 50,
            'city'             => 'Safi',
            'address'          => '1 rue Test',
            'phone'            => '0600000000',
            'status'           => 'publiee',
            'views_count'      => '42',
        ]);

        $this->assertIsInt($property->views_count);
        $this->assertEquals(42, $property->views_count);
    }

    // ─── Relations ──────────────────────────────────────────────────────────

    /** @test */
    public function property_belongs_to_user()
    {
        $user = User::factory()->create();
        $property = Property::create([
            'user_id'          => $user->id,
            'title'            => 'Test',
            'description'      => 'Desc',
            'price'            => 1000,
            'type_transaction' => 'vente',
            'type_bien'        => 'maison',
            'surface'          => 80,
            'city'             => 'Safi',
            'address'          => '1 rue Test',
            'phone'            => '0600000000',
            'status'           => 'publiee',
        ]);

        $this->assertInstanceOf(User::class, $property->user);
        $this->assertEquals($user->id, $property->user->id);
    }

    /** @test */
    public function property_has_many_ressources()
    {
        $user = User::factory()->create();
        $property = Property::create([
            'user_id'          => $user->id,
            'title'            => 'Test',
            'description'      => 'Desc',
            'price'            => 1000,
            'type_transaction' => 'vente',
            'type_bien'        => 'maison',
            'surface'          => 80,
            'city'             => 'Safi',
            'address'          => '1 rue',
            'phone'            => '0600000000',
            'status'           => 'publiee',
        ]);

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class, $property->ressources());
    }

    /** @test */
    public function property_has_many_commentaires()
    {
        $user = User::factory()->create();
        $property = Property::create([
            'user_id'          => $user->id,
            'title'            => 'Test',
            'description'      => 'Desc',
            'price'            => 1000,
            'type_transaction' => 'vente',
            'type_bien'        => 'maison',
            'surface'          => 80,
            'city'             => 'Safi',
            'address'          => '1 rue',
            'phone'            => '0600000000',
            'status'           => 'publiee',
        ]);

        Commentaire::create([
            'property_id' => $property->id,
            'content'     => 'Super bien !',
            'is_approved' => false,
        ]);

        $this->assertCount(1, $property->commentaires);
    }

    // ─── Fillable ────────────────────────────────────────────────────────────

    /** @test */
    public function property_fillable_fields_are_correct()
    {
        $property = new Property();
        $expected = [
            'user_id', 'title', 'description', 'price',
            'type_transaction', 'type_bien', 'surface', 'rooms',
            'city', 'address', 'phone', 'status', 'views_count',
            'is_approved', 'approved_at', 'latitude', 'longitude',
        ];

        foreach ($expected as $field) {
            $this->assertContains($field, $property->getFillable(), "Field [$field] should be fillable");
        }
    }
}
