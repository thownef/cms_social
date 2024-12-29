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
        switch ($this->login_type) {
            case LoginTypeEnum::NORMAL:
                return $this->getNormalLoginRules();
            case LoginTypeEnum::GOOGLE:
                return $this->getGoogleLoginRules();
            case LoginTypeEnum::FACEBOOK:
                return $this->getFacebookLoginRules();
            default:
                return [];
        }
    }

    private function getNormalLoginRules(): array
    {
        return [
            'login_type' => ['required', 'integer', Rule::in(LoginTypeEnum::getTypes())],
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'phone' => ['required', 'string', Rule::unique('users')->whereNull('deleted_at')->where('phone', $this->phone)],
            'date_of_birth' => ['required', 'date'],
            'gender' => ['required', 'numeric'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')
                    ->whereNull('deleted_at')
                    ->where('email', $this->email)
            ],
            'password' => [
                'required',
                'min:8',
                'regex:/^[a-zA-Z 0-9\_\/\(\)\=\+\~\-\`\@\$\!\#\&]*$/'
            ],
            'confirm_password' => [
                'required',
                'same:password'
            ],
        ];
    }

    private function getGoogleLoginRules(): array
    {
        return [
            'login_type' => ['required', 'integer', Rule::in(LoginTypeEnum::getTypes())],
        ];
    }

    private function getFacebookLoginRules(): array
    {
        return [
            'login_type' => ['required', 'integer', Rule::in(LoginTypeEnum::getTypes())],
        ];
    }
}
