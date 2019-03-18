<?php

namespace Tests\Feature;

use App\Member;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class MemberReadTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_returns_an_empty_array_of_members_when_no_members_exist()
    {
        $response = $this->getJson('/api/members');

        $response->assertStatus(200)
                ->assertJson([
                    'data' => []
                ]);
    }

    public function test_can_list_members(){
        $members = factory(Member::class, 2)->create()->map(function ($member){
            return $member->only(['id', 'name', 'position','gender']);
        });
    }
}
