<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\Travel;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTravelTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_user_can_not_access_adding_travel()
    {
        $response = $this->postJson('/api/v1/admin/travels');

        $response->assertStatus(401);
    }

    public function test_non_admin_user_can_not_access_adding_travel()
    {
        $this->seed(RoleSeeder::class);
        $user = User::factory()->create();
        $user->roles()->attach(Role::where('name', 'editor')->value('id'));

        $response = $this->actingAs($user)->postJson('/api/v1/admin/travels');

        $response->assertStatus(403);

    }

    public function test_admin_user_can_access_adding_travel()
    {
        $this->seed(RoleSeeder::class);
        $user = User::factory()->create();
        $user->roles()->attach(Role::where('name', 'admin')->value('id'));

        $response = $this->actingAs($user)->postJson('/api/v1/admin/travels', [
            'name' => 'travel name',
        ]);
        $response->assertStatus(422);

        $response = $this->actingAs($user)->postJson('/api/v1/admin/travels', [
            'name' => 'travel name',
            'is_public' => 1,
            'description' => 'some description',
            'number_of_days' => 5,
        ]);
        $response->assertStatus(201);

        $response = $this->get('/api/v1/travels');
        $response->assertJsonFragment(['name' => 'travel name']);

    }

    public function test_updates_travel_successfully_with_valid_data()
    {
        $this->seed(RoleSeeder::class);
        $user = User::factory()->create();
        $user->roles()->attach(Role::where('name', 'editor')->value('id'));
        $travel = Travel::factory()->create();

        $response = $this->actingAs($user)->putJson('/api/v1/admin/travels/'.$travel->id, [
            'name' => 'some new name',
        ]);
        $response->assertStatus(422);

        $response = $this->actingAs($user)->putJson('/api/v1/admin/travels/'.$travel->id, [
            'name' => 'some new name',
            'is_public' => 1,
            'description' => 'some description',
            'number_of_days' => 5,
        ]);
        $response->assertStatus(200);

        $response = $this->get('/api/v1/travels');

        $response->assertJsonFragment(['name' => 'some new name']);

    }
}
