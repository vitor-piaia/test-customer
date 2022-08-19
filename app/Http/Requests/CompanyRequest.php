<?php

namespace App\Http\Requests;

use App\Models\Company;
use Illuminate\Support\Facades\Validator;

class CompanyRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(!empty($this->route()->parameter('id'))) {
            if(Company::where('id', $this->route()->parameter('id'))->exists())
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
        Validator::extend(
            'cnpj_unique',
            function ($attribute, $value){
                $value = str_replace(['/', '.', '-'], ['', '', ''], $value);
                if(Company::where('cnpj', $value)->exists())
                    return false;
                return true;
            },
            'O campo :attribute já está sendo utilizado.'
        );

        switch ($this->route()->getActionMethod()){
            case 'store':
                $rules = [
                    'name' => 'required|string|max:150',
                    'cnpj' => 'required|string|max:18|regex:/^\d{2}\.\d{3}\.\d{3}\/\d{4}\-\d{2}$/|cnpj_unique',
                    'street' => 'required|string|max:150',
                    'number' => 'required|string|max:15',
                    'postcode' => 'required|string|max:10|regex:/^[0-9]{2}.[0-9]{3}-[0-9]{3}$/',
                    'neighborhood' => 'required|string|max:100',
                    'city' => 'required|string|max:80',
                    'state' => 'required|string|max:50'
                ];
                break;
            case 'update':
                $rules = [
                    'name' => 'required|string|max:150',
                    'street' => 'required|string|max:150',
                    'number' => 'required|string|max:15',
                    'postcode' => 'required|string|max:10|regex:/^[0-9]{2}.[0-9]{3}-[0-9]{3}$/',
                    'neighborhood' => 'required|string|max:100',
                    'city' => 'required|string|max:80',
                    'state' => 'required|string|max:50'
                ];
                break;
            default:
                $rules = [];
                break;
        }
        return $rules;
    }
}
