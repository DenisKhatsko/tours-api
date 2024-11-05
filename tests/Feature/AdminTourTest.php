<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\Travel;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTourTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_user_can_not_create_tour()
    {
        $travel = Travel::factory()->create();
        $response = $this->postJson('/api/v1/admin/travels/'.$travel->id.'/tours');

        $response->assertStatus(401);
    }

    public function test_non_admin_user_can_not_create_tour()
    {
        $this->seed(RoleSeeder::class);
        $user = User::factory()->create();
        $user->roles()->attach(Role::where('name', 'editor')->value('id'));
        $travel = Travel::factory()->create();

        $response = $this->actingAs($user)->postJson('api/v1/admin/travels/'.$travel->id.'/tours');

        $response->assertStatus(403);
    }

    public function test_admin_user_can_create_tour()
    {
        $this->seed(RoleSeeder::class);
        $user = User::factory()->create();
        $user->roles()->attach(Role::where('name', 'admin')->value('id'));
        $travel = Travel::factory()->create();

        $response = $this->actingAs($user)->postJson('api/v1/admin/travels/'.$travel->id.'/tours', [
            'name' => 'tour name',
        ]);
        $response->assertStatus(422);

        $response = $this->actingAs($user)->postJson('api/v1/admin/travels/'.$travel->id.'/tours', [
            'name' => 'tour name',
            'starting_date' => now()->toDateTimeString(),
            'ending_date' => now()->addDay()->toDateTimeString(),
            'price' => 123.45,
        ]);
        $response->assertStatus(201);

        $response = $this->get('/api/v1/travels/'.$travel->slug.'/tours');
        $response->assertJsonFragment(['name' => 'tour name']);

    }
}
