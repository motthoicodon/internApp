<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ExampleTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_returns_the_member_on_successfully_creating_a_new_member()
    {

        $data = [
            'name' => 'hoang.kenvin',
            'phone' => '+84964 191 965',
            'birthday' => '1991/02/19',
            'gender' => 'male',
            'position' => 'junior',
        ];

        $response = $this->postJson('/api/members', $data);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'name' => 'hoang.kenvin',
                    'phone' => '+84964 191 965',
                    'birthday' => '1991/02/19',
                    'gender' => 'male',
                ]
            ]);
    }

    public function test_it_returns_appropriate_field_validation_errors_when_creating_a_new_member_with_invalid_inputs_case_1()
    {
        $data = [
            'name' => '',
            'phone' => '',
            'birthday' => '',
            'gender' => '',
            'position' => '',
        ];

        $response = $this->postJson('/api/members', $data);

        $response->assertStatus(422)
            ->assertJson([
                'error' => [
                    'name' => ['The name field is required.'],
                    'phone' => ['The phone field is required.'],
                    'birthday' => ['The birthday field is required.'],
                    'position' => ['The position field is required.'],
                    'gender' => ['The gender field is required.'],
                ],
            ]);

        $data['name'] = 'hoang@';
        $data['phone'] = 'asd 2313';
        $data['birthday'] = '123abc';
        $data['position'] = 'intern2';
        $data['gender'] = '123';

        $response = $this->postJson('/api/members', $data);

        $response->assertStatus(422)
            ->assertJson([
                'error' => [
                    'name' => ['The name format is invalid.'],
                    'phone' => ['The phone format is invalid.'],
                    'birthday' => [
                        'The birthday does not match the format Y/m/d.',
                        'The birthday must be a date before today.',
                        'The birthday must be a date after 1959-01-01.'],
                    'position' => ['The selected position is invalid.'],
                    'gender' => ['The selected gender is invalid.'],
                ],
            ]);
    }

    public function test_it_returns_appropriate_field_validation_errors_when_creating_a_new_member_with_invalid_inputs_case_2()
    {
        $data = [
            'name' => 'scuti.asiascuti.asiascuti.asiascuti.asiascuti.asia1',
            'phone' => '12345678901234567890(',
            'birthday' => '',
            'gender' => '',
            'position' => '',
        ];

        $response = $this->postJson('/api/members', $data);

        $response->assertStatus(422)
            ->assertJson([
                'error' => [
                    'name' => ['The name may not be greater than 50 characters.'],
                    'phone' => ['The phone may not be greater than 20 characters.'],
                    'birthday' => ['The birthday field is required.'],
                    'position' => ['The position field is required.'],
                    'gender' => ['The gender field is required.'],
                ],
            ]);

    }
}
