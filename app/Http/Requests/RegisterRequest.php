<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class RegisterRequest extends FormRequest
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
     * Create a random refresh token for the user
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'refresh_token' => Str::random(20),
        ]);
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'password' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'refresh_token' => 'required|string'
        ];
    }


}
