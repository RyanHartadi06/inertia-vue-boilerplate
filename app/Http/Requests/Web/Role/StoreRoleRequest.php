<?php

namespace App\Http\Requests\Web\Role;

use App\Enums\RoleType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRoleRequest extends FormRequest
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
      'name' => ['required', 'string', 'max:255', 'unique:roles,name', Rule::notIn(RoleType::getValues())]
    ];
  }
}
