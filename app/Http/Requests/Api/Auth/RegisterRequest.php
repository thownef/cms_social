<?php

namespace App\Http\Requests\Api\Auth;

use App\Enums\AuthTypeEnum;
use App\Http\Requests\Api\BaseRequest;
use App\Rules\AuthEmail;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
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
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone' => 'sometimes|string',
            'age' => 'required|numeric',
            'gender' => 'required|numeric',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email'
            ],
            'password' => 'required|string',
            'confirm_password' => 'required|string|same:password',
        ];
    }
}
