<?php

namespace Tests\Feature;

use Illuminate\Support\Str;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectCreateTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testSuccessfullyCreatingNewProject()
    {
        $data = [
            'name' => 'ProJ 45',
            'deadline' => '2020/01/01',
            'type' => 'lab',
            'status' => 'doing',
        ];

        $response = $this->postJson('/api/projects', $data);

        $response->assertStatus(200)
                ->assertJson([
                    'data' => [
                        'name' => 'ProJ 45',
                        'deadline' => '2020/01/01',
                        'type' => 'lab',
                        'status' => 'doing'
                    ]
                ]);
    }

    public function testNoInputTypingWhenCreateNewProject()
    {
        $data = [
            'name' => '',
            'deadline' => '',
            'type' => '',
            'status' => '',
            'information' => ''
        ];

        $response = $this->postJson('/api/projects', $data);

        $response->assertStatus(422)
            ->assertJson([
                'error'=>[
                    'name'=> ['The name field is required.'],
                    'type'=>['The type field is required.'],
                    'status'=>['The status field is required.'],
                ]
            ]);
    }

    public function testExceedingLimitOfInputFieldNameInformationAndDeadlineOfProject()
    {
        $data = [
            'name' => Str::random(11),
            'information' => Str::random(301),
            'deadline' => '1958-02-19',
            'type' => 'lab',
            'status' => 'doing',
        ];

        $response = $this->postJson('/api/projects', $data);

        $response->assertStatus(422)
            ->assertJson([
                'error' => [
                    'name' => ['The name may not be greater than 10 characters.'],
                    'information' => ['The information may not be greater than 300 characters.'],
                    'deadline' => [
                        'The deadline does not match the format Y/m/d.',
                        'The deadline must be a date after today.'
                    ],
                ]
            ]);
    }

    public function testSuccessfullyCreatingProjectWithLimitOfLengthOfInformationAndName()
    {
        $projectName = Str::random(10);
        $projectInfo = Str::random(300);

        $data = [
            'name' => $projectName,
            'information' => $projectInfo,
            'deadline' => '2020/02/19',
            'type' => 'lab',
            'status' => 'doing',
        ];

        $response = $this->postJson('api/projects', $data);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'name' => $projectName,
                    'information' => $projectInfo,
                    'deadline' => '2020/02/19',
                    'type' => 'lab',
                    'status' => 'doing'
                ]
            ]);
    }

    public function testInvalidTypingInputFieldNameTypeAndStatus()
    {
        $data = [
            'name' => 'abcd@',
            'type' => 'maleasd',
            'status' => 'juniorasd',
        ];

        $response = $this->postJson('/api/projects', $data);

        $response->assertStatus(422)
            ->assertJson([
                'error' => [
                    'name' => ['The name format is invalid.'],
                    'type' => ['The selected type is invalid.'],
                    'status' => ['The selected status is invalid.'],
                ]
            ]);
    }
}
