<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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
            'name' => Str::random(51),
            'information' => Str::random(301),
            'phone' => '1234567890-1234567890',
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

    public function testSuccessfullyCreatingMemberWithLimitOfLengthOfInformationPhoneAndName()
    {

        $memberInfo = Str::random(300);
        $memberName = Str::random(50);

        $data = [
            'name' => $memberName,
            'phone' => '12345678901234567890',
            'birthday' => '1991/02/19',
            'gender' => 'male',
            'position' => 'junior',
            'information' => $memberInfo
        ];

        $response = $this->postJson('api/members', $data);

        $response->assertStatus(200)
                ->assertJson([
                    'data' => [
                        'name' => $memberName,
                        'information' => $memberInfo,
                        'phone' => '12345678901234567890',
                        'birthday' => '1991/02/19',
                        'gender' => 'male',
                        'position' => 'junior',
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

    public function testSuccessfullyCreatingNewMemberWithJPGImage()
    {

        Storage::fake(config('filesystems.default'));

        $data = [
            'name' => 'hoang kenvin',
            'phone' => '+84964 191 965',
            'birthday' => '1991/02/19',
            'gender' => 'male',
            'position' => 'junior',
            'avatar' => UploadedFile::fake()->image('avatar.jpg')
        ];

        $response = $this->postJson('/api/members', $data);

        // Assert the file was stored...
        Storage::disk(config('filesystems.default'))->assertExists(
            'avatars/' . str_slug('hoang kenvin') . '.jpg'
        );

        $response->assertStatus(200);
    }

    public function testSuccessfullyCreatingNewMemberWithPNGImage()
    {

        Storage::fake(config('filesystems.default'));

        $data = [
            'name' => 'hoang kenvin',
            'phone' => '+84964 191 965',
            'birthday' => '1991/02/19',
            'gender' => 'male',
            'position' => 'junior',
            'avatar' => UploadedFile::fake()->image('avatar.png')
        ];

        $response = $this->postJson('/api/members', $data);

        // Assert the file was stored...
        Storage::disk(config('filesystems.default'))->assertExists(
            'avatars/' . str_slug('hoang kenvin') . '.png'
        );

        $response->assertStatus(200);
    }

    public function testSuccessfullyCreatingNewMemberWithGIFImage()
    {

        Storage::fake(config('filesystems.default'));

        $data = [
            'name' => 'hoang kenvin',
            'phone' => '+84964 191 965',
            'birthday' => '1991/02/19',
            'gender' => 'male',
            'position' => 'junior',
            'avatar' => UploadedFile::fake()->image('avatar.gif')
        ];

        $response = $this->postJson('/api/members', $data);

        // Assert the file was stored...
        Storage::disk(config('filesystems.default'))->assertExists(
            'avatars/' . str_slug('hoang kenvin') . '.gif'
        );

        $response->assertStatus(200);
    }

    public function testUploadImageBiggerThan10MBWhenCreatingNewMember()
    {
        $size = 10241;

        Storage::fake(config('filesystems.default'));

        $data = [
            'name' => 'hoang kenvin',
            'phone' => '+84964 191 965',
            'birthday' => '1991/02/19',
            'gender' => 'male',
            'position' => 'junior',
            'avatar' => UploadedFile::fake()->image('avatar.png')->size($size)
        ];

        $response = $this->postJson('/api/members', $data);

        // // Assert a file does not exist..
        Storage::disk(config('filesystems.default'))->assertMissing(
            'avatars/' . str_slug('hoang kenvin') . '.png'
        );

        $response->assertStatus(422)
                ->assertJson([
                    'error' => [
                        'avatar' => ['The avatar may not be greater than 10240 kilobytes.']
                    ],
                    'code' => 422
                ]);
    }

    public function testUploadImageWithSize10MBWhenCreatingNewMember()
    {
        $size = 10240;

        Storage::fake(config('filesystems.default'));

        $data = [
            'name' => 'hoang kenvin',
            'phone' => '+84964 191 965',
            'birthday' => '1991/02/19',
            'gender' => 'male',
            'position' => 'junior',
            'avatar' => UploadedFile::fake()->create('image.png', $size)
        ];

        $response = $this->postJson('/api/members', $data);

        // Assert a file does not exist..
        Storage::disk(config('filesystems.default'))->assertExists(
            'avatars/' . str_slug('hoang kenvin') . '.png'
        );

        $response->assertStatus(200);
    }
}
