<?php

namespace Tests\Feature;

use App\Models\Reclamation;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReclamationTest extends TestCase
{
    use RefreshDatabase;

    // ─── store ──────────────────────────────────────────────────────────────

    /** @test */
    public function guest_cannot_submit_a_reclamation()
    {
        $response = $this->post(route('reclamations.store'), [
            'subject'  => 'Bug',
            'content'  => 'L\'annonce est en erreur.',
            'priority' => 'normale',
        ]);

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function authenticated_user_can_submit_a_reclamation()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('reclamations.store'), [
            'subject'  => 'Problème avec mon annonce',
            'content'  => 'Mon annonce n\'est pas visible sur la page de recherche.',
            'priority' => 'normale',
        ]);

        $response->assertRedirect(route('dashboard.index'));
        $this->assertDatabaseHas('reclamations', [
            'user_id' => $user->id,
            'subject' => 'Problème avec mon annonce',
            'status'  => 'ouvert',
            'is_read' => 0,
        ]);
    }

    /** @test */
    public function reclamation_validates_required_fields()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('reclamations.store'), []);

        $response->assertSessionHasErrors(['subject', 'content', 'priority']);
    }

    /** @test */
    public function reclamation_content_requires_minimum_10_characters()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('reclamations.store'), [
            'subject'  => 'Test',
            'content'  => 'Court',    // < 10
            'priority' => 'basse',
        ]);

        $response->assertSessionHasErrors(['content']);
    }

    /** @test */
    public function reclamation_validates_priority_enum()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('reclamations.store'), [
            'subject'  => 'Test',
            'content'  => 'Contenu suffisamment long pour être valide.',
            'priority' => 'invalide',
        ]);

        $response->assertSessionHasErrors(['priority']);
    }

    /** @test */
    public function new_reclamation_has_status_ouvert_and_is_not_read()
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('reclamations.store'), [
            'subject'  => 'Vérification du statut initial',
            'content'  => 'Je teste le statut par défaut d\'une réclamation.',
            'priority' => 'urgente',
        ]);

        $rec = Reclamation::where('user_id', $user->id)->first();
        $this->assertEquals('ouvert', $rec->status);
        $this->assertFalse((bool) $rec->is_read);
    }

    // ─── destroy ────────────────────────────────────────────────────────────

    /** @test */
    public function user_can_delete_their_own_reclamation()
    {
        $user = User::factory()->create();

        $rec = Reclamation::create([
            'user_id'  => $user->id,
            'subject'  => 'À supprimer',
            'message'  => 'Réclamation que je veux supprimer.',
            'priority' => 'basse',
            'status'   => 'ouvert',
            'is_read'  => false,
        ]);

        $response = $this->actingAs($user)->delete(route('reclamations.destroy', $rec));

        $response->assertRedirect();
        $this->assertDatabaseMissing('reclamations', ['id' => $rec->id]);
    }

    /** @test */
    public function user_cannot_delete_another_users_reclamation()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $rec = Reclamation::create([
            'user_id'  => $user1->id,
            'subject'  => 'Réclamation user1',
            'message'  => 'Contenu de la réclamation.',
            'priority' => 'normale',
            'status'   => 'ouvert',
            'is_read'  => false,
        ]);

        $response = $this->actingAs($user2)->delete(route('reclamations.destroy', $rec));

        $response->assertStatus(403);
        $this->assertDatabaseHas('reclamations', ['id' => $rec->id]);
    }
}
