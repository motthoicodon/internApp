<?php

namespace App\Http\Requests;

use App\WorksOn;
use Illuminate\Foundation\Http\FormRequest;

class CreateWorksOnRequest extends FormRequest
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
            'project_id' => 'required|exists:works_on,project_id',
            'member_id' => 'required|exists:works_on,member_id',
            'role' => 'required|in:' . implode(',', WorksOn::ROLES),
        ];
    }
}
