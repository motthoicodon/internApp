<?php

namespace App\Http\Requests;

use App\Project;
use Illuminate\Foundation\Http\FormRequest;

class EditProjectRequest extends FormRequest
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
            'name' => ['required','max:10','regex:/^[a-zA-Z0-9-.\s]*$/'],
            'information' => 'max:300',
            'deadline' => 'nullable|date_format:"Y/m/d"',
            'type'      => 'required|in:' . implode(',', Project::TYPES),
            'status'      => 'required|in:' . implode(',', Project::STATUS),
        ];
    }
}
