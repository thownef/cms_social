<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

abstract class BaseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    abstract public function rules(): array;
}
