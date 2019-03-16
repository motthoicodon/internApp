<?php

namespace App\Http\Requests;

use App\Member;
use App\Rules\DateOfBirth;
use Illuminate\Foundation\Http\FormRequest;

class EditMemberRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required','max:50','regex:/^[a-zA-Z0-9-.\s]*$/'],
            'information' => 'max:300',
            'phone' => ['required','max:20','regex:/^[0-9()-.+\s\/]*$/'],
            'birthday' => ['required','date_format:"Y/m/d"','before:today', new DateOfBirth()],
            'avatar' => 'file|image|max:10240',
            'position'      => 'required|in:' . implode(',', Member::POSITIONS),
            'gender'      => 'required|in:' . implode(',', Member::GENDERS),
        ];
    }
}
