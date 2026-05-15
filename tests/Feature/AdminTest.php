<?php

namespace Tests\Feature;

use App\Models\Property;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    private function makeAdmin(): User
    {
        return User::factory()->create(['is_admin' => true, 'is_active' => true]);
    }

    private function makeUser(): User
    {
        return User::factory()->create(['is_admin' => false, 'is_active' => true]);
    }

    private function makeProperty(User $user, array $overrides = []): Property
    {
        return Property::create(array_merge([
            'user_id'          => $user->id,
            'title'            => 'Bien Admin Test',
            'description'      => 'Description',
            'price'            => 100000,
            'type_transaction' => 'vente',
            'type_bien'        => 'appartement',
            'surface'          => 60,
            'city'             => 'Safi',
            'address'          => '5 rue Admin',
            'phone'            => '0600000000',
            'status'           => 'publiee',
            'is_approved'      => false,
        ], $overrides));
    }

    // ─── Accès dashboard ────────────────────────────────────────────────────

    /** @test */
    public function admin_can_access_admin_dashboard()
    {
        $admin    = $this->makeAdmin();
        $response = $this->actingAs($admin)->get(route('admin.dashboard'));
        $response->assertStatus(200);
    }

    /** @test */
    public function regular_user_cannot_access_admin_dashboard()
    {
        $user     = $this->makeUser();
        $response = $this->actingAs($user)->get(route('admin.dashboard'));
        // Redirigé (pas admin) → login
        $response->assertRedirect();
    }

    /** @test */
    public function guest_cannot_access_admin_dashboard()
    {
        $response = $this->get(route('admin.dashboard'));
        $response->assertRedirect(route('login'));
    }

    // ─── Modération d'annonce ───────────────────────────────────────────────

    /** @test */
    public function admin_can_approve_a_property()
    {
        $admin    = $this->makeAdmin();
        $user     = $this->makeUser();
        $property = $this->makeProperty($user);

        $response = $this->actingAs($admin)
            ->patch(route('admin.properties.moderate', $property), ['action' => 'active']);

        $response->assertRedirect();
        $this->assertDatabaseHas('properties', [
            'id'          => $property->id,
            'is_approved' => 1,
            'status'      => 'publiee',
        ]);
    }

    /** @test */
    public function admin_can_reject_a_property()
    {
        $admin    = $this->makeAdmin();
        $user     = $this->makeUser();
        $property = $this->makeProperty($user);

        $response = $this->actingAs($admin)
            ->patch(route('admin.properties.moderate', $property), ['action' => 'rejected']);

        $response->assertRedirect();
        $this->assertDatabaseHas('properties', [
            'id'          => $property->id,
            'is_approved' => 0,
            'status'      => 'brouillon',
        ]);
    }

    /** @test */
    public function moderate_action_validates_allowed_values()
    {
        $admin    = $this->makeAdmin();
        $user     = $this->makeUser();
        $property = $this->makeProperty($user);

        $response = $this->actingAs($admin)
            ->patch(route('admin.properties.moderate', $property), ['action' => 'invalide']);

        $response->assertSessionHasErrors(['action']);
    }

    /** @test */
    public function admin_can_delete_any_property()
    {
        $admin    = $this->makeAdmin();
        $user     = $this->makeUser();
        $property = $this->makeProperty($user);

        $response = $this->actingAs($admin)
            ->delete(route('admin.properties.destroy', $property));

        $response->assertRedirect();
        $this->assertDatabaseMissing('properties', ['id' => $property->id]);
    }

    // ─── Gestion utilisateurs ───────────────────────────────────────────────

    /** @test */
    public function admin_can_create_a_user()
    {
        $admin = $this->makeAdmin();

        $response = $this->actingAs($admin)->post(route('admin.users.store'), [
            'name'                  => 'Nouveau Utilisateur',
            'email'                 => 'nouveau@example.com',
            'password'              => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('users', ['email' => 'nouveau@example.com']);
    }

    /** @test */
    public function admin_can_toggle_user_active_status()
    {
        $admin    = $this->makeAdmin();
        $user     = $this->makeUser();

        $this->assertTrue($user->is_active);

        $this->actingAs($admin)->patch(route('admin.users.toggle', $user));

        $this->assertFalse((bool) $user->fresh()->is_active);

        // Toggle again → should become active again
        $this->actingAs($admin)->patch(route('admin.users.toggle', $user));
        $this->assertTrue((bool) $user->fresh()->is_active);
    }

    /** @test */
    public function admin_cannot_toggle_another_admin()
    {
        $admin1 = $this->makeAdmin();
        $admin2 = $this->makeAdmin();

        $response = $this->actingAs($admin1)->patch(route('admin.users.toggle', $admin2));

        $response->assertRedirect();
        $response->assertSessionHas('error');
    }

    /** @test */
    public function admin_can_delete_a_user()
    {
        $admin = $this->makeAdmin();
        $user  = $this->makeUser();

        $response = $this->actingAs($admin)->delete(route('admin.users.destroy', $user));

        $response->assertRedirect();
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    /** @test */
    public function admin_cannot_delete_another_admin()
    {
        $admin1 = $this->makeAdmin();
        $admin2 = $this->makeAdmin();

        $response = $this->actingAs($admin1)->delete(route('admin.users.destroy', $admin2));

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('users', ['id' => $admin2->id]);
    }

    // ─── API Stats ──────────────────────────────────────────────────────────

    /** @test */
    public function admin_can_fetch_views_stats_as_json()
    {
        $admin    = $this->makeAdmin();
        $response = $this->actingAs($admin)->get(route('admin.stats.views', ['range' => '7d']));

        $response->assertStatus(200);
        $response->assertJsonStructure(['labels', 'values']);
    }

    /** @test */
    public function views_stats_returns_correct_number_of_labels_for_7d()
    {
        $admin    = $this->makeAdmin();
        $response = $this->actingAs($admin)->getJson(route('admin.stats.views', ['range' => '7d']));

        $data = $response->json();
        $this->assertCount(7, $data['labels']);
        $this->assertCount(7, $data['values']);
    }

    /** @test */
    public function views_stats_returns_24_entries_for_24h_range()
    {
        $admin    = $this->makeAdmin();
        $response = $this->actingAs($admin)->getJson(route('admin.stats.views', ['range' => '24h']));

        $data = $response->json();
        $this->assertCount(24, $data['labels']);
    }

    /** @test */
    public function views_stats_returns_30_entries_for_30d_range()
    {
        $admin    = $this->makeAdmin();
        $response = $this->actingAs($admin)->getJson(route('admin.stats.views', ['range' => '30d']));

        $data = $response->json();
        $this->assertCount(30, $data['labels']);
    }
}
