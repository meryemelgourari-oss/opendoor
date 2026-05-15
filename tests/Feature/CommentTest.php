<?php

namespace Tests\Feature;

use App\Models\Commentaire;
use App\Models\Property;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    private function makePublishedProperty(User $user): Property
    {
        return Property::create([
            'user_id'          => $user->id,
            'title'            => 'Bien test',
            'description'      => 'Description',
            'price'            => 200000,
            'type_transaction' => 'vente',
            'type_bien'        => 'appartement',
            'surface'          => 60,
            'city'             => 'Safi',
            'address'          => '1 rue Principale',
            'phone'            => '0600000000',
            'status'           => 'publiee',
            'is_approved'      => true,
        ]);
    }

    // ─── store ──────────────────────────────────────────────────────────────

    /** @test */
    public function guest_can_post_a_comment_with_guest_name()
    {
        $owner    = User::factory()->create();
        $property = $this->makePublishedProperty($owner);

        $response = $this->post(route('comments.store', $property), [
            'content'    => 'Très beau bien, je suis intéressé.',
            'guest_name' => 'Mohamed',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('commentaires', [
            'property_id' => $property->id,
            'guest_name'  => 'Mohamed',
            'is_approved' => 0,
        ]);
    }

    /** @test */
    public function authenticated_user_can_post_a_comment()
    {
        $owner    = User::factory()->create();
        $commenter = User::factory()->create();
        $property = $this->makePublishedProperty($owner);

        $response = $this->actingAs($commenter)->post(route('comments.store', $property), [
            'content' => 'Bien localisé et très propre.',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('commentaires', [
            'property_id' => $property->id,
            'user_id'     => $commenter->id,
            'is_approved' => 0,
        ]);
    }

    /** @test */
    public function comment_requires_minimum_content_length()
    {
        $owner    = User::factory()->create();
        $property = $this->makePublishedProperty($owner);

        $response = $this->post(route('comments.store', $property), [
            'content' => 'Ok',  // trop court (< 5)
        ]);

        $response->assertSessionHasErrors(['content']);
    }

    /** @test */
    public function comment_content_cannot_exceed_1000_characters()
    {
        $owner    = User::factory()->create();
        $property = $this->makePublishedProperty($owner);

        $response = $this->post(route('comments.store', $property), [
            'content' => str_repeat('a', 1001),
        ]);

        $response->assertSessionHasErrors(['content']);
    }

    /** @test */
    public function new_comment_is_not_approved_by_default()
    {
        $owner    = User::factory()->create();
        $property = $this->makePublishedProperty($owner);

        $this->post(route('comments.store', $property), [
            'content'    => 'Commentaire de test pour vérifier is_approved.',
            'guest_name' => 'Visiteur',
        ]);

        $comment = Commentaire::where('property_id', $property->id)->first();
        $this->assertFalse((bool) $comment->is_approved);
    }

    // ─── approve ────────────────────────────────────────────────────────────

    /** @test */
    public function property_owner_can_approve_a_comment()
    {
        $owner    = User::factory()->create();
        $property = $this->makePublishedProperty($owner);

        $comment = Commentaire::create([
            'property_id' => $property->id,
            'content'     => 'Commentaire en attente',
            'is_approved' => false,
        ]);

        $response = $this->actingAs($owner)
            ->patch(route('comments.approve', $comment));

        $response->assertRedirect();
        $this->assertDatabaseHas('commentaires', ['id' => $comment->id, 'is_approved' => 1]);
    }

    /** @test */
    public function non_owner_cannot_approve_a_comment()
    {
        $owner    = User::factory()->create();
        $other    = User::factory()->create();
        $property = $this->makePublishedProperty($owner);

        $comment = Commentaire::create([
            'property_id' => $property->id,
            'content'     => 'Commentaire',
            'is_approved' => false,
        ]);

        $response = $this->actingAs($other)
            ->patch(route('comments.approve', $comment));

        $response->assertStatus(403);
    }

    // ─── destroy ────────────────────────────────────────────────────────────

    /** @test */
    public function property_owner_can_delete_a_comment()
    {
        $owner    = User::factory()->create();
        $property = $this->makePublishedProperty($owner);

        $comment = Commentaire::create([
            'property_id' => $property->id,
            'content'     => 'À supprimer',
            'is_approved' => true,
        ]);

        $response = $this->actingAs($owner)
            ->delete(route('comments.destroy', $comment));

        $response->assertRedirect();
        $this->assertDatabaseMissing('commentaires', ['id' => $comment->id]);
    }

    /** @test */
    public function non_owner_cannot_delete_a_comment()
    {
        $owner    = User::factory()->create();
        $other    = User::factory()->create();
        $property = $this->makePublishedProperty($owner);

        $comment = Commentaire::create([
            'property_id' => $property->id,
            'content'     => 'Commentaire protégé',
            'is_approved' => true,
        ]);

        $response = $this->actingAs($other)
            ->delete(route('comments.destroy', $comment));

        $response->assertStatus(403);
        $this->assertDatabaseHas('commentaires', ['id' => $comment->id]);
    }
}
