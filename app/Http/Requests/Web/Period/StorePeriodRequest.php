<?php

namespace App\Http\Requests\Web\Period;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePeriodRequest extends FormRequest
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
            'year'              => 'required|integer|max:2200|' . Rule::unique('periods')->whereNull('deleted_at'),
            'weight'            => 'required|integer|max:1000000',
            'direction_weight'  => 'required|integer|max:1000000',
        ];
    }
}
