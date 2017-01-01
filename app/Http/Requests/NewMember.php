<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewMember extends FormRequest
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
            'knesset_id' => 'required|numeric',
            'party_id' => 'required',
            'active' => 'required|boolean',
            'image' => 'required|url',
            'first_name' => 'required',
            'last_name' => 'required',
            'first_name_english' => 'required',
            'last_name_english' => 'required',
            'gender' => 'required',
            'mk_status_id' => 'required',
            'birth_date' => 'required|date',
            'present' => 'required|boolean',
        ];
    }
}
