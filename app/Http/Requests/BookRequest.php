<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'profile_id'  => 'required|integer',
            'name'        => 'required',
            'poster'      => 'string',
            'pages'       => 'integer',
            'genre'       => 'string',
            'is_read'     => 'boolean',
            'in_progress' => 'boolean'
        ];
    }
}
