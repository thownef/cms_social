<?php

namespace App\Http\Requests\Api\Conversation;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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
            'message' => 'required|string|max:255',
            'is_group' => 'required|boolean',
            'group_id' => 'required_if:is_group,true|exists:groups,id',
            'ids' => 'required|array',
            'ids.*' => 'required|exists:users,id',
        ];
    }
}
