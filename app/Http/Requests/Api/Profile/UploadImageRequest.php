<?php

namespace App\Http\Requests\Api\Profile;

use Illuminate\Foundation\Http\FormRequest;

class UploadImageRequest extends FormRequest
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
            'content' => 'nullable|string',
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'type' => 'required|string|in:avatar,cover',
            'is_public' => 'sometimes|boolean',
        ];
    }
}
