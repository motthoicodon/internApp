<?php

namespace Tests\Feature;

use App\Member;
use App\Project;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WorksOnTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_assign_successfully_members_to_projects()
    {
        $projects = factory(Project::class, 3)->create();
        $members = factory(Member::class, 3)->create();

        $project = $projects[0];

        $data = [
            'member_id' => $members[0]->id,
            'role'      => 'pm',
        ];

        $response = $this->postJson("/api/projects/{$project->id}/members/", $data);

        $response->assertStatus(200)
                ->assertJson([
                    'data' => [
                        'member_id' => $members[0]->id,
                        'role' => 'pm',
                        'project_id' => $project->id
                    ]
                ]);
    }

    public function test_assign_invalid_members_to_projects()
    {
        $projects = factory(Project::class, 3)->create();
        $members = factory(Member::class, 3)->create();

        $project = $projects[0];

        $data = [
            'member_id' => 1000,
            'role'      => 'pm',
        ];

        $response = $this->postJson("/api/projects/{$project->id}/members/", $data);

        $response->assertStatus(422)
            ->assertJson([
                'error' => [
                    'member_id' => ['The selected member id is invalid.'],
                ]
            ]);
    }

    public function test_assign_members_to_projects_with_invalid_role()
    {
        $projects = factory(Project::class, 3)->create();
        $members = factory(Member::class, 3)->create();

        $project = $projects[0];

        $data = [
            'member_id' => $members[0]->id,
            'role'      => 'ceo of company',
        ];

        $response = $this->postJson("/api/projects/{$project->id}/members/", $data);

        $response->assertStatus(422)
            ->assertJson([
                'error' => [
                    'role' => ['The selected role is invalid.'],
                ]
            ]);
    }

    public function test_assign_members_to_invalid_projects()
    {
        $projects = factory(Project::class, 3)->create();
        $members = factory(Member::class, 3)->create();

        $project = $projects[0];

        $data = [
            'member_id' => $members[0]->id,
            'role'      => 'pm',
        ];

        $response = $this->postJson("/api/projects/100/members/", $data);

        $response->assertStatus(404)
            ->assertJson([
                'error' => 'Does not exists any Project with the specified indentificator',
            ]);
    }
}
