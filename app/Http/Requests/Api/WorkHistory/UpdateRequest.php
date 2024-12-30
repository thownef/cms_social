<?php

namespace App\Http\Requests\Api\WorkHistory;

use Illuminate\Foundation\Http\FormRequest;

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
            'job_title' => 'sometimes|string|max:255',
            'company_name' => 'sometimes|string|max:255',
            'date_started' => 'sometimes|date',
            'date_ended' => 'sometimes|nullable|date|after:date_started',
            'is_public' => 'sometimes|boolean',
            'is_current' => 'sometimes|boolean'
        ];
    }
}
