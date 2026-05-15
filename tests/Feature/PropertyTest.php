<?php

namespace Tests\Feature;

use App\Models\Property;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PropertyTest extends TestCase
{
    use RefreshDatabase;

    // ─── Helper ─────────────────────────────────────────────────────────────

    private function makeProperty(User $user, array $overrides = []): Property
    {
        return Property::create(array_merge([
            'user_id'          => $user->id,
            'title'            => 'Appartement lumineux',
            'description'      => 'Beau 3 pièces en centre-ville',
            'price'            => 350000,
            'type_transaction' => 'vente',
            'type_bien'        => 'appartement',
            'surface'          => 75,
            'rooms'            => 3,
            'city'             => 'Safi',
            'address'          => '12 avenue Mohamed V',
            'phone'            => '0600112233',
            'status'           => 'publiee',
            'is_approved'      => true,
        ], $overrides));
    }

    // ─── Listing public ─────────────────────────────────────────────────────

    /** @test */
    public function guest_can_view_properties_index()
    {
        $response = $this->get(route('properties.index'));
        $response->assertStatus(200);
    }

    /** @test */
    public function only_published_and_approved_properties_are_listed()
    {
        $owner = User::factory()->create();

        $visible  = $this->makeProperty($owner, ['status' => 'publiee', 'is_approved' => true]);
        $draft    = $this->makeProperty($owner, ['title' => 'Brouillon', 'status' => 'brouillon', 'is_approved' => false]);
        $pending  = $this->makeProperty($owner, ['title' => 'En attente', 'status' => 'publiee', 'is_approved' => false]);

        $response = $this->get(route('properties.index'));
        $response->assertStatus(200);
        $response->assertSee($visible->title);
        $response->assertDontSee($draft->title);
        $response->assertDontSee($pending->title);
    }

    /** @test */
    public function properties_can_be_filtered_by_contract_type()
    {
        $owner = User::factory()->create();
        $vente    = $this->makeProperty($owner, ['title' => 'À Vendre', 'type_transaction' => 'vente']);
        $location = $this->makeProperty($owner, ['title' => 'À Louer',  'type_transaction' => 'location']);

        $response = $this->get(route('properties.index', ['contract' => 'vente']));
        $response->assertSee($vente->title);
        $response->assertDontSee($location->title);
    }

    /** @test */
    public function properties_can_be_filtered_by_city()
    {
        $owner = User::factory()->create();
        $safi     = $this->makeProperty($owner, ['title' => 'Bien Safi',     'city' => 'Safi']);
        $casa     = $this->makeProperty($owner, ['title' => 'Bien Casablanca', 'city' => 'Casablanca']);

        $response = $this->get(route('properties.index', ['city' => 'Safi']));
        $response->assertSee($safi->title);
        $response->assertDontSee($casa->title);
    }

    // ─── Détail public ──────────────────────────────────────────────────────

    /** @test */
    public function guest_can_view_a_published_property()
    {
        $owner    = User::factory()->create();
        $property = $this->makeProperty($owner);

        $response = $this->get(route('properties.show', $property));
        $response->assertStatus(200);
        $response->assertSee($property->title);
    }

    /** @test */
    public function viewing_a_property_increments_views_count_for_guest()
    {
        $owner    = User::factory()->create();
        $property = $this->makeProperty($owner);
        $initial  = $property->views_count;

        $this->get(route('properties.show', $property));

        $this->assertEquals($initial + 1, $property->fresh()->views_count);
    }

    /** @test */
    public function owner_viewing_their_own_property_does_not_increment_views()
    {
        $owner    = User::factory()->create();
        $property = $this->makeProperty($owner);
        $initial  = $property->views_count;

        $this->actingAs($owner)->get(route('properties.show', $property));

        $this->assertEquals($initial, $property->fresh()->views_count);
    }

    // ─── Création ───────────────────────────────────────────────────────────

    /** @test */
    public function guest_cannot_access_create_form()
    {
        $response = $this->get(route('properties.create'));
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function authenticated_user_can_access_create_form()
    {
        $user     = User::factory()->create();
        $response = $this->actingAs($user)->get(route('properties.create'));
        $response->assertStatus(200);
    }

    /** @test */
    public function authenticated_user_can_store_a_property()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('properties.store'), [
            'title'            => 'Maison spacieuse',
            'description'      => 'Belle maison avec jardin',
            'price'            => 800000,
            'type_transaction' => 'vente',
            'type_bien'        => 'maison',
            'surface'          => 150,
            'rooms'            => 5,
            'city'             => 'Safi',
            'address'          => '3 rue des Oliviers',
            'phone'            => '0611223344',
            'status'           => 'publiee',
        ]);

        $response->assertRedirect(route('dashboard.my-properties'));
        $this->assertDatabaseHas('properties', [
            'title'   => 'Maison spacieuse',
            'user_id' => $user->id,
        ]);
    }

    /** @test */
    public function store_validates_required_fields()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('properties.store'), []);

        $response->assertSessionHasErrors(['title', 'description', 'price', 'surface', 'city', 'address', 'phone']);
    }

    /** @test */
    public function store_validates_type_transaction_enum()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('properties.store'), [
            'title'            => 'Test',
            'description'      => 'Desc',
            'price'            => 100,
            'type_transaction' => 'INVALIDE',
            'type_bien'        => 'maison',
            'surface'          => 50,
            'city'             => 'Safi',
            'address'          => '1 rue',
            'phone'            => '0600000000',
            'status'           => 'publiee',
        ]);

        $response->assertSessionHasErrors(['type_transaction']);
    }

    // ─── Édition & Mise à jour ──────────────────────────────────────────────

    /** @test */
    public function owner_can_access_edit_form()
    {
        $owner    = User::factory()->create();
        $property = $this->makeProperty($owner);

        $response = $this->actingAs($owner)->get(route('properties.edit', $property));
        $response->assertStatus(200);
    }

    /** @test */
    public function non_owner_cannot_access_edit_form()
    {
        $owner   = User::factory()->create();
        $other   = User::factory()->create();
        $property = $this->makeProperty($owner);

        $response = $this->actingAs($other)->get(route('properties.edit', $property));
        $response->assertStatus(403);
    }

    /** @test */
    public function owner_can_update_their_property()
    {
        $owner    = User::factory()->create();
        $property = $this->makeProperty($owner);

        $response = $this->actingAs($owner)->put(route('properties.update', $property), [
            'title'   => 'Titre modifié',
            'price'   => 400000,
            'surface' => 80,
            'city'    => 'Safi',
            'address' => '15 rue Liberté',
        ]);

        $response->assertRedirect(route('dashboard.my-properties'));
        $this->assertDatabaseHas('properties', ['title' => 'Titre modifié', 'id' => $property->id]);
    }

    /** @test */
    public function non_owner_cannot_update_property()
    {
        $owner   = User::factory()->create();
        $other   = User::factory()->create();
        $property = $this->makeProperty($owner);

        $response = $this->actingAs($other)->put(route('properties.update', $property), [
            'title'   => 'Hack',
            'price'   => 1,
            'surface' => 1,
            'city'    => 'X',
            'address' => 'Y',
        ]);

        $response->assertStatus(403);
    }

    // ─── Suppression ────────────────────────────────────────────────────────

    /** @test */
    public function owner_can_delete_their_property()
    {
        $owner    = User::factory()->create();
        $property = $this->makeProperty($owner);

        $response = $this->actingAs($owner)->delete(route('properties.destroy', $property));

        $response->assertRedirect();
        $this->assertDatabaseMissing('properties', ['id' => $property->id]);
    }

    /** @test */
    public function non_owner_cannot_delete_property()
    {
        $owner   = User::factory()->create();
        $other   = User::factory()->create();
        $property = $this->makeProperty($owner);

        $response = $this->actingAs($other)->delete(route('properties.destroy', $property));
        $response->assertStatus(403);
    }

    // ─── Statut ─────────────────────────────────────────────────────────────

    /** @test */
    public function owner_can_update_property_status()
    {
        $owner    = User::factory()->create();
        $property = $this->makeProperty($owner);

        $response = $this->actingAs($owner)->patch(route('properties.update-status', $property), [
            'status' => 'archivee',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('properties', ['id' => $property->id, 'status' => 'archivee']);
    }

    /** @test */
    public function status_update_validates_allowed_values()
    {
        $owner    = User::factory()->create();
        $property = $this->makeProperty($owner);

        $response = $this->actingAs($owner)->patch(route('properties.update-status', $property), [
            'status' => 'invalide',
        ]);

        $response->assertSessionHasErrors(['status']);
    }
}
