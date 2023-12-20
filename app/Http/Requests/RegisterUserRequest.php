<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|max:50|alpha',
            'last_name' => 'required|max:50|alpha',
            'username' => 'required|unique:users,username',
            'phone_number' => 'required|numeric',
            'bvn' => 'required|numeric|digits:11|unique:users,bvn',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'pin' => 'nullable',
            'photo' => 'nullable',
            'tx_ref' => 'nullable',
            'narration' => 'nullable',
            'country' => 'required'
        ];
    }
    
}
