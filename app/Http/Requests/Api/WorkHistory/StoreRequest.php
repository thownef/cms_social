<?php

namespace App\Http\Requests\Api\WorkHistory;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'job_title' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'date_started' => 'required|date',
            'date_ended' => 'nullable|date|after:date_started',
            'is_public' => 'boolean'
        ];
    }
}
