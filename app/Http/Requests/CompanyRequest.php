<?php

namespace App\Http\Requests;

class CompanyRequest extends ApiRequest
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
            'name' => 'required|string|max:150',
            'cnpj' => 'required|string|max:18',
            'street' => 'required|string|max:150',
            'number' => 'required|string|max:15',
            'postcode' => 'required|string|max:10',
            'neighborhood' => 'required|string|max:100',
            'city' => 'required|string|max:80',
            'state' => 'required|string|max:50'
        ];
    }
}
