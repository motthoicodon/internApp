<?php

namespace Tests\Feature;

use App\Member;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MemberDeleteTest extends TestCase
{
    use WithFaker;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_successfully_removing_the_member()
    {
        $member = Member::create([
            'name'=> $this->faker->userName,
            'phone'=> $this->faker->tollFreePhoneNumber,
            'birthday'=> $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'position'=> 'junior',
            'gender'=> 'male',
        ]);

        $response = $this->deleteJson("/api/members/{$member->id}", []);

        $response->assertStatus(200);

        $response = $this->getJson("/api/members/{$member->id}");

        $response->assertStatus(404);
    }
}
