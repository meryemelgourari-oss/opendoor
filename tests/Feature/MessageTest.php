<?php

namespace Tests\Feature;

use App\Models\Message;
use App\Models\Property;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MessageTest extends TestCase
{
    use RefreshDatabase;

    private function makeProperty(User $user): Property
    {
        return Property::create([
            'user_id'          => $user->id,
            'title'            => 'Bien test',
            'description'      => 'Description',
            'price'            => 300000,
            'type_transaction' => 'vente',
            'type_bien'        => 'maison',
            'surface'          => 90,
            'city'             => 'Safi',
            'address'          => '1 rue des Acacias',
            'phone'            => '0600000000',
            'status'           => 'publiee',
            'is_approved'      => true,
        ]);
    }

    // ─── store (visiteur non connecté) ──────────────────────────────────────

    /** @test */
    public function guest_can_send_a_message_with_name_and_email()
    {
        $owner    = User::factory()->create();
        $property = $this->makeProperty($owner);

        $response = $this->post(route('messages.store', $property), [
            'visitor_name'  => 'Karim Alaoui',
            'visitor_email' => 'karim@example.com',
            'content'       => 'Bonjour, je souhaite visiter ce bien rapidement.',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('messages', [
            'property_id'   => $property->id,
            'receiver_id'   => $owner->id,
            'visitor_name'  => 'Karim Alaoui',
            'visitor_email' => 'karim@example.com',
            'is_read'       => 0,
        ]);
    }

    /** @test */
    public function guest_message_requires_name_and_email()
    {
        $owner    = User::factory()->create();
        $property = $this->makeProperty($owner);

        $response = $this->post(route('messages.store', $property), [
            'content' => 'Message sans identité',
        ]);

        $response->assertSessionHasErrors(['visitor_name', 'visitor_email']);
    }

    /** @test */
    public function guest_message_requires_minimum_content_length()
    {
        $owner    = User::factory()->create();
        $property = $this->makeProperty($owner);

        $response = $this->post(route('messages.store', $property), [
            'visitor_name'  => 'Test',
            'visitor_email' => 'test@test.com',
            'content'       => 'Court',  // < 10 chars
        ]);

        $response->assertSessionHasErrors(['content']);
    }

    // ─── store (utilisateur connecté) ───────────────────────────────────────

    /** @test */
    public function authenticated_user_can_send_message_without_name_or_email()
    {
        $owner    = User::factory()->create();
        $sender   = User::factory()->create(['name' => 'Alice', 'email' => 'alice@example.com']);
        $property = $this->makeProperty($owner);

        $response = $this->actingAs($sender)->post(route('messages.store', $property), [
            'content' => 'Je suis intéressé par votre annonce, pouvez-vous me contacter ?',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('messages', [
            'property_id'   => $property->id,
            'receiver_id'   => $owner->id,
            'visitor_name'  => 'Alice',
            'visitor_email' => 'alice@example.com',
        ]);
    }

    /** @test */
    public function authenticated_user_message_does_not_require_visitor_fields()
    {
        $owner    = User::factory()->create();
        $sender   = User::factory()->create();
        $property = $this->makeProperty($owner);

        $response = $this->actingAs($sender)->post(route('messages.store', $property), [
            'content' => 'Message valide sans visitor_name ni visitor_email.',
        ]);

        $response->assertSessionDoesntHaveErrors(['visitor_name', 'visitor_email']);
    }

    // ─── messages are unread by default ─────────────────────────────────────

    /** @test */
    public function new_message_is_unread_by_default()
    {
        $owner    = User::factory()->create();
        $property = $this->makeProperty($owner);

        $this->post(route('messages.store', $property), [
            'visitor_name'  => 'Bob',
            'visitor_email' => 'bob@example.com',
            'content'       => 'Je voudrais avoir plus de détails sur ce bien.',
        ]);

        $message = Message::where('property_id', $property->id)->first();
        $this->assertFalse((bool) $message->is_read);
    }

    // ─── index (dashboard) ──────────────────────────────────────────────────

    /** @test */
    public function authenticated_user_can_access_messages_dashboard()
    {
        $user     = User::factory()->create();
        $response = $this->actingAs($user)->get(route('messages.index'));
        $response->assertStatus(200);
    }

    /** @test */
    public function guest_cannot_access_messages_dashboard()
    {
        $response = $this->get(route('messages.index'));
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function messages_are_marked_as_read_when_owner_visits_dashboard()
    {
        $owner    = User::factory()->create();
        $property = $this->makeProperty($owner);

        Message::create([
            'property_id'   => $property->id,
            'receiver_id'   => $owner->id,
            'visitor_name'  => 'Test',
            'visitor_email' => 'test@test.com',
            'content'       => 'Message non lu initialement',
            'is_read'       => false,
        ]);

        $this->actingAs($owner)->get(route('messages.index'));

        $this->assertDatabaseHas('messages', [
            'property_id' => $property->id,
            'is_read'     => 1,
        ]);
    }
}
