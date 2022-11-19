<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReadRequest extends FormRequest
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
            'profile_id' => 'required|integer',
            'book_id'    => 'integer',
            'pages'      => 'required|integer',
            'timestamp'  => 'integer'
        ];
    }
}
