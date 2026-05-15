<?php

namespace Tests\Unit;

use App\Models\Property;
use App\Models\User;
use App\Policies\PropertyPolicy;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PropertyPolicyTest extends TestCase
{
    use RefreshDatabase;

    private PropertyPolicy $policy;

    protected function setUp(): void
    {
        parent::setUp();
        $this->policy = new PropertyPolicy();
    }

    private function makeProperty(User $owner): Property
    {
        return Property::create([
            'user_id'          => $owner->id,
            'title'            => 'Bien test',
            'description'      => 'Desc',
            'price'            => 100000,
            'type_transaction' => 'vente',
            'type_bien'        => 'maison',
            'surface'          => 90,
            'city'             => 'Safi',
            'address'          => '10 rue de la Paix',
            'phone'            => '0600000000',
            'status'           => 'publiee',
        ]);
    }

    // ─── viewAny ─────────────────────────────────────────────────────────────

    /** @test */
    public function anyone_can_view_any_property()
    {
        $this->assertTrue($this->policy->viewAny(null));

        $user = User::factory()->create();
        $this->assertTrue($this->policy->viewAny($user));
    }

    // ─── view ────────────────────────────────────────────────────────────────

    /** @test */
    public function anyone_can_view_a_single_property()
    {
        $owner    = User::factory()->create();
        $property = $this->makeProperty($owner);

        $this->assertTrue($this->policy->view(null, $property));

        $visitor = User::factory()->create();
        $this->assertTrue($this->policy->view($visitor, $property));
    }

    // ─── create ──────────────────────────────────────────────────────────────

    /** @test */
    public function authenticated_user_can_create_property()
    {
        $user = User::factory()->create(['is_admin' => false]);
        $this->assertTrue($this->policy->create($user));
    }

    /** @test */
    public function admin_can_create_property()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $this->assertTrue($this->policy->create($admin));
    }

    // ─── update ──────────────────────────────────────────────────────────────

    /** @test */
    public function owner_can_update_their_property()
    {
        $owner    = User::factory()->create();
        $property = $this->makeProperty($owner);

        $this->assertTrue($this->policy->update($owner, $property));
    }

    /** @test */
    public function other_user_cannot_update_property()
    {
        $owner   = User::factory()->create();
        $other   = User::factory()->create(['is_admin' => false]);
        $property = $this->makeProperty($owner);

        $this->assertFalse($this->policy->update($other, $property));
    }

    /** @test */
    public function admin_can_update_any_property()
    {
        $owner    = User::factory()->create();
        $admin    = User::factory()->create(['is_admin' => true]);
        $property = $this->makeProperty($owner);

        $this->assertTrue($this->policy->update($admin, $property));
    }

    // ─── delete ──────────────────────────────────────────────────────────────

    /** @test */
    public function owner_can_delete_their_property()
    {
        $owner    = User::factory()->create();
        $property = $this->makeProperty($owner);

        $this->assertTrue($this->policy->delete($owner, $property));
    }

    /** @test */
    public function other_user_cannot_delete_property()
    {
        $owner    = User::factory()->create();
        $other    = User::factory()->create(['is_admin' => false]);
        $property = $this->makeProperty($owner);

        $this->assertFalse($this->policy->delete($other, $property));
    }

    /** @test */
    public function admin_can_delete_any_property()
    {
        $owner    = User::factory()->create();
        $admin    = User::factory()->create(['is_admin' => true]);
        $property = $this->makeProperty($owner);

        $this->assertTrue($this->policy->delete($admin, $property));
    }
}
