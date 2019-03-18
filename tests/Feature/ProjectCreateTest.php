<?php

namespace Tests\Feature;

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
    public function test_successfully_creating_a_new_project()
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

    public function test_no_input_typing_when_create_a_new_project()
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

    public function test_exceeding_limit_of_length_input_field()
    {
        $data = [
            'name' => 'abcdef1234abcdef1234abcdef1234abcdef1234abcdef1234a',
            'information' => 'abcdef1234abcdef1234abcdef1234abcdef1234abcdef1234abcdef1234abcdef1234abcdef1234abcdef1234abcdef1234abcdef1234abcdef1234abcdef1234abcdef1234abcdef1234abcdef1234abcdef1234abcdef1234abcdef1234abcdef1234abcdef1234abcdef1234abcdef1234abcdef1234abcdef1234abcdef1234abcdef1234abcdef1234abcdef1234abcdef1234a',
            'deadline' => '1958-02-19',
            'type' => 'maleasd',
            'status' => 'juniorasd',
        ];

        $response = $this->postJson('/api/projects', $data);

        $response->assertStatus(422)
            ->assertJson([
                'error' => [
                    'name' => ['The name may not be greater than 10 characters.'],
                    'information' => ['The information may not be greater than 300 characters.'],
                    'type' => ['The selected type is invalid.'],
                    'deadline' => [
                        'The deadline does not match the format Y/m/d.',
                        'The deadline must be a date after today.'
                    ],
                    'status' => ['The selected status is invalid.'],
                ]
            ]);
    }

    public function test_invalid_typing_input_field_name_type_and_status()
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
