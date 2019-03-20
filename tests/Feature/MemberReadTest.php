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
    public function testItReturnsAnEmptyArrayOfMembersWhenNoMembersExist()
    {
        $response = $this->getJson('/api/members');

        $response->assertStatus(200)
                ->assertJson([
                    'data' => []
                ]);
    }

    public function testCanListMembers()
    {
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

    public function testCanGetMemberSpecifyById()
    {
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

    public function testItReturns404NotFoundWhenGetInvalidMember()
    {
        $id = 1000;
        $response = $this->getJson("api/members/{$id}");
        $response->assertStatus(404)
                ->assertJson([
                    'error' => 'Does not exists any Member with the specified indentificator',
                    'code'  => 404
                ]);
    }
}
