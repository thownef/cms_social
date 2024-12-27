<?php

namespace App\Http\Requests\Api\Auth;

use App\Enums\LoginTypeEnum;
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
            'login_type'        => ['required', 'integer', Rule::in(LoginTypeEnum::getTypes())],
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone' => 'required|string',
            'date_of_birth' => 'required|date',
            'gender' => 'required|numeric',
            'email'             => [
                'required_if:login_type,' . LoginTypeEnum::NORMAL,
                'email',
                'max:255',
                Rule::unique('users')
                    ->whereNull('deleted_at')
                    ->where('email', $this->email)
            ],
            'password'          => [
                'required_if:login_type,' . LoginTypeEnum::NORMAL,
                'min:8',
                'regex:/^[a-zA-Z 0-9\_\/\(\)\=\+\~\-\`\@\$\!\#\&]*$/'
            ],
            'confirm_password' => [
                'required_if:login_type,' . LoginTypeEnum::NORMAL,
                'string',
                'same:password'
            ],
        ];
    }
}
