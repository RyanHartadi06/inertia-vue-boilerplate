<?php

namespace App\Http\Requests\Web\IndicatorUnit;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateIndicatorUnitRequest extends FormRequest
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
            'id'    => 'required|exists:indicator_units,id',
            'name'  => 'required|string|max:255|' . Rule::unique('indicator_units')->ignore($this->id)->whereNull('deleted_at')
        ];
    }
}
