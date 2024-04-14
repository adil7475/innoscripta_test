<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class SettingUpdateRequest extends FormRequest
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
            'sources' => 'array',
            'sources.*' => 'exists:sources,id',
            'categories' => 'array',
            'categories.*' => 'exists:categories,id',
            'authors' => 'array',
            'authors.*' => 'exists:authors,id',
        ];
    }
}
