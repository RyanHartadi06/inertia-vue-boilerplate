<?php

namespace App\Http\Requests\Web\Guide;

use App\Rules\FileUploadRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateGuideRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id'            => 'required|exists:guides,id',
            'name'          => 'required|max:255',
            'description'   => 'nullable|max:10000',
            'file'          => ['nullable', 'max:2048', new FileUploadRule('mimes:pdf')],
        ];
    }
}
