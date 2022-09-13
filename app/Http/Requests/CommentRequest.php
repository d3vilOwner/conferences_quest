<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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
            'media_path' => '',
            'content' => '',
            'report_id' => 'required',
            'user_id' => 'required',
            'conference_title' => 'required|string',
            'username' =>  'required|string',
            'report_topic' => 'required|string',
            'report_author' => 'required'
        ];
    }
}
