<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Property;
use App\Models\Message;
use App\Models\Reclamation;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserModelTest extends TestCase
{
    use RefreshDatabase;

    // ─── Casts ──────────────────────────────────────────────────────────────

    /** @test */
    public function is_admin_is_cast_to_boolean()
    {
        $user = User::factory()->create(['is_admin' => 0]);
        $this->assertIsBool($user->is_admin);
        $this->assertFalse($user->is_admin);
    }

    /** @test */
    public function is_active_is_cast_to_boolean()
    {
        $user = User::factory()->create(['is_active' => 1]);
        $this->assertIsBool($user->is_active);
        $this->assertTrue($user->is_active);
    }

    /** @test */
    public function password_is_hidden_from_serialization()
    {
        $user = User::factory()->create();
        $array = $user->toArray();
        $this->assertArrayNotHasKey('password', $array);
        $this->assertArrayNotHasKey('remember_token', $array);
    }

    // ─── Relations ──────────────────────────────────────────────────────────

    /** @test */
    public function user_has_many_properties()
    {
        $user = User::factory()->create();

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class, $user->properties());
    }

    /** @test */
    public function user_has_many_received_messages()
    {
        $user = User::factory()->create();
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class, $user->receivedMessages());
    }

    /** @test */
    public function user_has_many_reclamations()
    {
        $user = User::factory()->create();
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class, $user->reclamations());
    }

    // ─── Fillable ────────────────────────────────────────────────────────────

    /** @test */
    public function user_fillable_fields_are_correct()
    {
        $user = new User();
        $expected = ['name', 'email', 'password', 'is_admin', 'is_active'];

        foreach ($expected as $field) {
            $this->assertContains($field, $user->getFillable(), "Field [$field] should be fillable");
        }
    }
}
