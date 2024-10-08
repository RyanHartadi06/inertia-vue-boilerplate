<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequestByName extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function prepareForValidation()
    {
        $this->merge([
            'search' => $this->get('search'),
            'page' => $this->get('page') ?? 1,
            'per_page' => $this->get('per_page') ?? 10,
            'sort' => $this->get('sort') ?? 'name',
            'order' => $this->get('order') ?? 'asc',
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
