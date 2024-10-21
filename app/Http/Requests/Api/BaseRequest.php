<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

abstract class BaseRequest extends FormRequest
{
    abstract public function authorize(): bool;

    abstract public function rules(): array;
}
