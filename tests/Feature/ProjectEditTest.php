<?php

namespace Tests\Feature;

use App\Project;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectEditTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_returns_the_updated_project_on_successfully_updating_the_project()
    {
        $projects = factory(Project::class, 3)->create();

        $project = $projects[0];

        $data = [
            'name'    => 'new name',
            'type'    => 'single',
            'status'  =>  'cancelled',
        ];

        $response = $this->putJson("api/projects/{$project->id}", $data);

        $response->assertStatus(200)
                ->assertJson([
                    'data'=>[
                        'name'      => 'new name',
                        'type'      => 'single',
                        'status'    =>  'cancelled',
                    ]
                ]);
    }

    public function test_it_returns_appropriate_field_validation_errors_when_updating_the_project_with_invalid_inputs()
    {

        $projects = factory(Project::class, 3)->create();

        $project = $projects[0];

        $data = [
            'name'  => null,
            'type'  => '',
            'status'=>  '',
        ];


        $response = $this->putJson("api/projects/{$project->id}", $data);

        $response->assertStatus(422)
            ->assertJson([
                'error' => [
                    'name'      => ['The name field is required.'],
                    'type'     => ['The type field is required.'],
                    'status'  => ['The status field is required.'],
                ]
            ]);
    }
}
