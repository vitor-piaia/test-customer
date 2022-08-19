<?php

namespace App\Http\Requests;

use App\Models\Customer;

class CustomerRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(!empty($this->route()->parameter('id'))) {
            if(Customer::where('id', $this->route()->parameter('id'))->exists())
                return true;
            return false;
        }
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        switch ($this->route()->getActionMethod()){
            case 'store':
                $rules = [
                    'name' => 'required|string|max:150',
                    'email' => 'required|string|max:150|email|unique:customers',
                    'phone' => 'required|string|max:16|regex:/\(\d{2}\) \d{4,5}\-\d{4}/',
                    'birth' => 'required|string|max:150',
                    'born' => 'required|string|max:100',
                    'companies' => 'required|array',
                    'companies.*' => 'required|exists:companies,id'
                ];
                break;
            case 'update':
                $rules = [
                    'name' => 'required|string|max:150',
                    'phone' => 'required|string|max:16|regex:/\(\d{2}\) \d{4,5}\-\d{4}/',
                    'birth' => 'required|string|max:150',
                    'born' => 'required|string|max:100',
                    'companies' => 'required|array',
                    'companies.*' => 'required|exists:companies,id'
                ];
                break;
            default:
                $rules = [];
                break;
        }
        return $rules;
    }
}
