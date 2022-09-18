<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MeetingCreateRequest extends FormRequest
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
            'topic' => 'required|string',
            'start_time' => 'required|date',
            'duration' => 'required',
            'agenda' => 'required|string',
            'host_video' => 'required',
            'participant_video' => 'required',
            'report_id' => 'required',
            'user_id' => 'required'
        ];
    }
}