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
    public function testReturnsTheUpdatedMemberOnSuccessfullyUpdatingTheProject()
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

    public function testItReturnsAppropriateFieldValidationRrrorsWhenUpdatingTheProjectWithInvalidInputs()
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
