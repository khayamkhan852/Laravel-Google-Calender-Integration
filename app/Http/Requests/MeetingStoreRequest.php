<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MeetingStoreRequest extends FormRequest
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
            'subject' => ['required', 'string'],
            'meeting_date' => ['required', 'date'],
            'meeting_time' => ['required'],
            'user_one' => ['required', 'numeric', 'exists:users,id'],
            'user_two' => ['required', 'numeric', 'exists:users,id'],
        ];
    }
}
