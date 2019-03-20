<?php

namespace Tests\Feature;

use App\Project;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectDeleteTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testSuccessfullyRemovingTheProject()
    {
        $projects = factory(Project::class, 3)->create();

        $project = $projects[0];

        $response = $this->deleteJson("api/projects/{$project->id}");

        $response->assertStatus(200);

        $this->assertDatabaseMissing('projects', ['id'=>$project->id]);
    }
}
