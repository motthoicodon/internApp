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

        $members = factory(Member::class, 2)->create();

        $response = $this->getJson('/api/members');

        $response->assertStatus(200)
                 ->assertJson([
                    'data'=> [
                        [
                            'id'=> $members[0]->id,
                            'name'=> $members[0]->name,
                            'position'=> $members[0]->position,
                            'gender'=> $members[0]->gender,
                        ],
                        [
                            'id'=> $members[1]->id,
                            'name'=> $members[1]->name,
                            'position'=> $members[1]->position,
                            'gender'=> $members[1]->gender,
                        ],
                    ]
                 ]);

    }

    public function test_can_get_member_specify_by_id(){

        $members = factory(Member::class, 3)->create();

        $response= $this->get("api/members/{$members[0]->id}");

        $response->assertStatus(200)
                ->assertJson([
                   'data' => [
                      'id' => $members[0]->id,
                       'name'=> $members[0]->name,
                       'position'=> $members[0]->position,
                       'gender'=> $members[0]->gender,
                   ]
                ]);

    }
}
