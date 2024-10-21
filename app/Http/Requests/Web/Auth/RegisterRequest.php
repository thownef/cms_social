<?php

namespace App\Http\Requests\Web\Auth;

use App\Enums\AuthTypeEnum;
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
            'name' => 'required|string',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                new AuthEmail(data_get($this->input(), 'role', ''))
            ],
            'password' => 'required|string',
            'confirm_password' => 'required|string|same:password',
            'role' => ['required', Rule::in(AuthTypeEnum::getTypes())],
        ];
    }
}
