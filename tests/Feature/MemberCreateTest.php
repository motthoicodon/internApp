<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MemberCreateTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testSuccessfullyCreatingNewMember()
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
                    'position' => 'junior',
                ]
            ]);
    }

    public function testNoInputTypingWhenCreateNewMember()
    {
        $data = [
            'name' => '',
            'phone' => '',
            'birthday' => '',
            'gender' => '',
            'position' => ''
        ];

        $response = $this->postJson('/api/members', $data);

        $response->assertStatus(422)
            ->assertJson([
                'error'=>[
                    'name'=> ['The name field is required.'],
                    'phone'=>['The phone field is required.'],
                    'birthday'=>['The birthday field is required.'],
                    'gender'=>['The gender field is required.'],
                    'position'=>['The position field is required.'],
                ]
            ]);
    }

    public function testExceedingLimitOfLengthOfAllInputFieldOfMember()
    {
        $data = [
            'name' => 'abcdef1234abcdef1234abcdef1234abcdef1234abcdef1234a',
            'information' => 'abcdef1234abcdef1234abcdef1234abcdef1234abcdef1234abcdef1234abcdef1234abcdef1234abcdef1234abcdef1234abcdef1234abcdef1234abcdef1234abcdef1234abcdef1234abcdef1234abcdef1234abcdef1234abcdef1234abcdef1234abcdef1234abcdef1234abcdef1234abcdef1234abcdef1234abcdef1234abcdef1234abcdef1234abcdef1234abcdef1234a',
            'phone' => '096419196509641919651',
            'birthday' => '1958/02/19',
            'gender' => 'male',
            'position' => 'junior',
        ];

        $response = $this->postJson('/api/members', $data);

        $response->assertStatus(422)
            ->assertJson([
                'error' => [
                    'name' => ['The name may not be greater than 50 characters.'],
                    'information' => ['The information may not be greater than 300 characters.'],
                    'phone' => ['The phone may not be greater than 20 characters.'],
                    'birthday' => ['The birthday must be a date after 1959-01-01.'],
                ]
            ]);
    }

    public function testInvalidTypingInputFieldNamePhoneAndBirthday()
    {
        $data = [
            'name' => 'hoang@kenvin',
            'phone' => '(+84)a964 191 965',
            'birthday' => '19/02/1991',
            'gender' => 'male',
            'position' => 'junior'
        ];

        $response = $this->postJson('/api/members', $data);

        $response->assertStatus(422)
            ->assertJson([
                'error' => [
                    'name' => ['The name format is invalid.'],
                    'phone' => ['The phone format is invalid.'],
                    'birthday' => ['The birthday does not match the format Y/m/d.',
                        'The birthday must be a date before today.',
                        'The birthday must be a date after 1959-01-01.'],
                ]
            ]);
    }
}
