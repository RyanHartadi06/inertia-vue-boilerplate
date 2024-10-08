<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Validator;

class FileUploadRule implements ValidationRule
{
    private $rule;

    public function __construct(string $rule)
    {
        $this->rule = $rule;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $imageValidator = Validator::make([$attribute => $value], [
            $attribute => $this->rule,
        ]);

        $stringValidator = Validator::make([$attribute => $value], [
            $attribute => ['string'],
        ]);

        if ($imageValidator->fails() && $stringValidator->fails()) {
            $fail('The :attribute is not valid file.');
        }
    }
}
