<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ContactRule implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $pattern = '/^[\d()+\- ]+$/';

        // Check if the value matches the pattern
        return preg_match($pattern, $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ":attribute must be a proper contact number.";
    }
}
