<?php

namespace Tests\Feature;

use App\Member;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MemberEditTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testReturnsTheUpdatedMemberOnSuccessfullyUpdatingTheMember()
    {
        $member = Member::create([
            'name'=> $this->faker->userName,
            'phone'=> $this->faker->tollFreePhoneNumber,
            'birthday'=> $this->faker->date($format = 'Y/m/d', $max = 'now'),
            'position'=> 'junior',
            'gender'=> 'male',
        ]);

        $data = [
            'name' => 'new name',
            'position'    => 'senior',
            'gender'      =>  'male',
            'phone'=> '123456789',
            'birthday'=> $this->faker->date($format = 'Y/m/d', $max = 'now')
        ];

        $response = $this->putJson("api/members/{$member->id}", $data);

        $response->assertStatus(200)
                ->assertJson([
                   'data'=>[
                       'name' => 'new name',
                       'position'    => 'senior',
                       'gender'      =>  'male',
                       'phone'=> '123456789',
                   ]
                ]);
    }

    public function testItReturnsAppropriateFieldValidationRrrorsWhenUpdatingTheMemberWithInvalidInputs()
    {

        $member = Member::create([
            'name'=> $this->faker->userName,
            'phone'=> $this->faker->tollFreePhoneNumber,
            'birthday'=> $this->faker->date($format = 'Y/m/d', $max = 'now'),
            'position'=> 'junior',
            'gender'=> 'male',
        ]);

        $data = [
            'name'      => null,
            'position'  => '',
            'gender'    =>  '',
            'phone'     => '',
            'birthday'  => ''
        ];


        $response = $this->putJson("api/members/{$member->id}", $data);

        $response->assertStatus(422)
                 ->assertJson([
                    'error' => [
                        'name'      => ['The name field is required.'],
                        'phone'     => ['The phone field is required.'],
                        'birthday'  => ['The birthday field is required.'],
                        'position'  => ['The position field is required.'],
                        'gender'    => ['The gender field is required.'],
                    ]
                 ]);
    }
}
