<?php

namespace Tests\Feature;

use App\Models\Property;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    // ─── Pages statiques ────────────────────────────────────────────────────

    /** @test */
    public function home_page_loads_successfully()
    {
        $response = $this->get(route('home'));
        $response->assertStatus(200);
    }

    /** @test */
    public function about_page_loads_successfully()
    {
        $response = $this->get(route('about'));
        $response->assertStatus(200);
    }

    /** @test */
    public function services_page_loads_successfully()
    {
        $response = $this->get(route('services'));
        $response->assertStatus(200);
    }

    /** @test */
    public function legal_page_loads_successfully()
    {
        $response = $this->get(route('legal'));
        $response->assertStatus(200);
    }

    /** @test */
    public function contact_page_loads_successfully()
    {
        $response = $this->get(route('contact'));
        $response->assertStatus(200);
    }

    // ─── Annonces publiques ─────────────────────────────────────────────────

    /** @test */
    public function properties_index_page_loads_successfully()
    {
        $response = $this->get(route('properties.index'));
        $response->assertStatus(200);
    }

    /** @test */
    public function properties_nearby_page_loads_successfully()
    {
        $response = $this->get(route('properties.nearby'));
        $response->assertStatus(200);
    }

    /** @test */
    public function properties_analytics_page_loads_successfully()
    {
        $response = $this->get(route('properties.analytics'));
        $response->assertStatus(200);
    }

    /** @test */
    public function nearby_returns_only_published_approved_properties_as_json_data()
    {
        $user = User::factory()->create();

        $published = Property::create([
            'user_id'          => $user->id,
            'title'            => 'Bien visible',
            'description'      => 'Desc',
            'price'            => 100000,
            'type_transaction' => 'vente',
            'type_bien'        => 'maison',
            'surface'          => 80,
            'city'             => 'Safi',
            'address'          => '1 rue',
            'phone'            => '0600000000',
            'status'           => 'publiee',
            'is_approved'      => true,
            'latitude'         => 32.2994,
            'longitude'        => -9.2372,
        ]);

        $hidden = Property::create([
            'user_id'          => $user->id,
            'title'            => 'Bien caché',
            'description'      => 'Desc',
            'price'            => 50000,
            'type_transaction' => 'location',
            'type_bien'        => 'appartement',
            'surface'          => 40,
            'city'             => 'Safi',
            'address'          => '2 rue',
            'phone'            => '0600000000',
            'status'           => 'brouillon',
            'is_approved'      => false,
        ]);

        $response = $this->get(route('properties.nearby'));
        $response->assertStatus(200);
        // La vue reçoit $properties (collection JSON-able) ; on vérifie le contenu HTML
        $response->assertSee($published->title);
        $response->assertDontSee($hidden->title);
    }

    // ─── Dashboard (auth requis) ─────────────────────────────────────────────

    /** @test */
    public function guest_cannot_access_user_dashboard()
    {
        $response = $this->get(route('dashboard.index'));
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function authenticated_user_can_access_dashboard()
    {
        $user     = User::factory()->create();
        $response = $this->actingAs($user)->get(route('dashboard.index'));
        $response->assertStatus(200);
    }

    /** @test */
    public function authenticated_user_can_access_my_properties()
    {
        $user     = User::factory()->create();
        $response = $this->actingAs($user)->get(route('dashboard.my-properties'));
        $response->assertStatus(200);
    }
}
