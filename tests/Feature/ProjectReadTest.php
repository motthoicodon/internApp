<?php

namespace Tests\Feature;

use App\Project;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectReadTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testItReturnsAnEmptyArrayOfProjectsWhenNoProjectsExist()
    {
        $response = $this->getJson('/api/members');

        $response->assertStatus(200)
            ->assertJson([
                'data' => []
            ]);
    }

    public function testCanListProjects()
    {

        $projects = factory(Project::class, 2)->create();

        $response = $this->getJson('/api/projects');

        $response->assertStatus(200)
            ->assertJson([
                'data'=> [
                    [
                        'name'=> $projects[0]->name,
                        'deadline'=> $projects[0]->deadline,
                        'type'=> $projects[0]->type,
                        'status'=> $projects[0]->status,
                    ],
                    [
                        'name'=> $projects[1]->name,
                        'deadline'=> $projects[1]->deadline,
                        'type'=> $projects[1]->type,
                        'status'=> $projects[1]->status,
                    ],
                ]
            ]);
    }

    public function testCanGetProjectSpecifyById()
    {

        $projects = factory(Project::class, 3)->create();

        $response= $this->get("api/projects/{$projects[0]->id}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'name'=> $projects[0]->name,
                    'deadline'=> $projects[0]->deadline,
                    'type'=> $projects[0]->type,
                    'status'=> $projects[0]->status,
                ]
            ]);
    }
}
