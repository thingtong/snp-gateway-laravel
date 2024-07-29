<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ThaiEnglishPersonName implements ValidationRule
{
    /**
     * Run the validation rule.
     * https://www.ninenik.com/%E0%B9%81%E0%B8%99%E0%B8%A7%E0%B8%97%E0%B8%B2%E0%B8%87%E0%B8%95%E0%B8%A3%E0%B8%A7%E0%B8%88%E0%B8%82%E0%B9%89%E0%B8%AD%E0%B8%A1%E0%B8%B9%E0%B8%A5%E0%B9%80%E0%B8%89%E0%B8%9E%E0%B8%B2%E0%B8%B0%E0%B8%A0%E0%B8%B2%E0%B8%A9%E0%B8%B2%E0%B9%84%E0%B8%97%E0%B8%A2_%E0%B8%A0%E0%B8%B2%E0%B8%A9%E0%B8%B2%E0%B8%AD%E0%B8%B1%E0%B8%87%E0%B8%81%E0%B8%A4%E0%B8%A9%E0%B8%94%E0%B9%89%E0%B8%A7%E0%B8%A2_Regular_Expression-877.html
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $pattern = '/^[ก-๏a-zA-Z\s]+$/';
        $isValid = preg_match($pattern, $value);

        if (! $isValid) {
            $fail("The $attribute must be Thai or English characters.");
        }
    }
}
