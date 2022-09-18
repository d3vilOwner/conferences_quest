<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportStoreRequest extends FormRequest
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
            'topic' => 'required|string|min:2|max:255',
            'report_start' => 'required|date_format:H:i',
            'report_end' => 'required|date_format:H:i|after:report_start',
            'description' => '',
            'presentation' => '',
            'conference_id' => 'required',
            'user_id' => 'required',
            'conference_title' => 'required|string',
            'username' => 'required|string',
            'is_online' => 'required'
        ];
    }
}
