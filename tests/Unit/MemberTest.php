<?php

namespace Tests\Unit;

use App\Models\Member;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MemberTest extends TestCase
{
    use WithFaker;



    /** @test */
    public function a_user_can_create_a_member()
    {
        $data = [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'joining_date' => fake()->date(),
        ];

        $response = $this->post(route('members.store'), $data);

        $response->assertStatus(302);
        $response->assertRedirect(route('members.index'));
        $this->assertDatabaseHas('members', $data);
    }

    /** @test */
    public function a_user_can_update_a_member()
    {
        $member = Member::factory()->create();

        $data = [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'joining_date' => fake()->date(),
        ];

        $response = $this->put(route('members.update', $member->id), $data);

        $response->assertStatus(302);
        $response->assertRedirect(route('members.index'));
        $this->assertDatabaseHas('members', $data);
    }
}
