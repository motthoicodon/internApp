<?php

namespace Tests\Feature;

use App\Member;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MemberDeleteTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testSuccessfullyRemovingTheMember()
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

        $this->assertDatabaseMissing('members', ['id'=>$member->id]);

        $uri = "/api/members/{$member->id}";

        $this->return404WhenSendGetJsonRequest($uri);
    }
}
