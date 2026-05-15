<?php

namespace Tests\Unit;

use App\Models\Commentaire;
use App\Models\Message;
use App\Models\Reclamation;
use App\Models\Property;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OtherModelsTest extends TestCase
{
    use RefreshDatabase;

    private function createProperty(User $user): Property
    {
        return Property::create([
            'user_id'          => $user->id,
            'title'            => 'Bien Test',
            'description'      => 'Description',
            'price'            => 500000,
            'type_transaction' => 'vente',
            'type_bien'        => 'maison',
            'surface'          => 120,
            'city'             => 'Safi',
            'address'          => '5 avenue Hassan II',
            'phone'            => '0600000001',
            'status'           => 'publiee',
            'is_approved'      => true,
        ]);
    }

    // ─── Commentaire ────────────────────────────────────────────────────────

    /** @test */
    public function commentaire_belongs_to_property()
    {
        $user     = User::factory()->create();
        $property = $this->createProperty($user);

        $comment = Commentaire::create([
            'property_id' => $property->id,
            'content'     => 'Très beau bien !',
            'is_approved' => false,
        ]);

        $this->assertInstanceOf(Property::class, $comment->property);
        $this->assertEquals($property->id, $comment->property->id);
    }

    /** @test */
    public function commentaire_belongs_to_user_optionally()
    {
        $user     = User::factory()->create();
        $property = $this->createProperty($user);

        // Commentaire d'un visiteur non connecté (user_id null)
        $comment = Commentaire::create([
            'property_id' => $property->id,
            'guest_name'  => 'Visiteur Anonyme',
            'content'     => 'Très intéressant.',
            'is_approved' => false,
        ]);

        $this->assertNull($comment->user_id);
        $this->assertEquals('Visiteur Anonyme', $comment->guest_name);
    }

    /** @test */
    public function commentaire_is_approved_cast_to_boolean()
    {
        $user     = User::factory()->create();
        $property = $this->createProperty($user);

        $comment = Commentaire::create([
            'property_id' => $property->id,
            'content'     => 'Beau bien',
            'is_approved' => 0,
        ]);

        $this->assertIsBool($comment->is_approved);
        $this->assertFalse($comment->is_approved);
    }

    /** @test */
    public function commentaire_fillable_fields_are_correct()
    {
        $model    = new Commentaire();
        $expected = ['content', 'property_id', 'user_id', 'guest_name', 'is_approved'];

        foreach ($expected as $field) {
            $this->assertContains($field, $model->getFillable(), "Field [$field] missing from Commentaire fillable");
        }
    }

    // ─── Message ────────────────────────────────────────────────────────────

    /** @test */
    public function message_belongs_to_property()
    {
        $user     = User::factory()->create();
        $property = $this->createProperty($user);

        $message = Message::create([
            'property_id'   => $property->id,
            'receiver_id'   => $user->id,
            'visitor_name'  => 'Jean Dupont',
            'visitor_email' => 'jean@example.com',
            'content'       => 'Je suis intéressé par ce bien.',
            'is_read'       => false,
        ]);

        $this->assertInstanceOf(Property::class, $message->property);
        $this->assertEquals($property->id, $message->property->id);
    }

    /** @test */
    public function message_belongs_to_receiver_user()
    {
        $user     = User::factory()->create();
        $property = $this->createProperty($user);

        $message = Message::create([
            'property_id'   => $property->id,
            'receiver_id'   => $user->id,
            'visitor_name'  => 'Alice',
            'visitor_email' => 'alice@example.com',
            'content'       => 'Disponible ce week-end ?',
            'is_read'       => false,
        ]);

        $this->assertInstanceOf(User::class, $message->receiver);
        $this->assertEquals($user->id, $message->receiver->id);
    }

    /** @test */
    public function message_is_read_cast_to_boolean()
    {
        $user     = User::factory()->create();
        $property = $this->createProperty($user);

        $message = Message::create([
            'property_id'   => $property->id,
            'receiver_id'   => $user->id,
            'visitor_name'  => 'Test',
            'visitor_email' => 'test@test.com',
            'content'       => 'Message de test',
            'is_read'       => 1,
        ]);

        $this->assertIsBool($message->is_read);
        $this->assertTrue($message->is_read);
    }

    /** @test */
    public function message_fillable_fields_are_correct()
    {
        $model    = new Message();
        $expected = ['property_id', 'receiver_id', 'visitor_name', 'visitor_email', 'content', 'is_read'];

        foreach ($expected as $field) {
            $this->assertContains($field, $model->getFillable(), "Field [$field] missing from Message fillable");
        }
    }

    // ─── Reclamation ────────────────────────────────────────────────────────

    /** @test */
    public function reclamation_belongs_to_user()
    {
        $user = User::factory()->create();

        $rec = Reclamation::create([
            'user_id'  => $user->id,
            'subject'  => 'Bug sur annonce',
            'message'  => 'L\'annonce ne s\'affiche pas correctement.',
            'priority' => 'normale',
            'status'   => 'ouvert',
            'is_read'  => false,
        ]);

        $this->assertInstanceOf(User::class, $rec->user);
        $this->assertEquals($user->id, $rec->user->id);
    }

    /** @test */
    public function reclamation_fillable_fields_are_correct()
    {
        $model    = new Reclamation();
        $expected = ['user_id', 'subject', 'message', 'is_read', 'priority', 'status'];

        foreach ($expected as $field) {
            $this->assertContains($field, $model->getFillable(), "Field [$field] missing from Reclamation fillable");
        }
    }
}
