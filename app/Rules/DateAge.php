<?php

namespace App\Rules;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class DateAge implements Rule
{
    public function passes($attribute, $value)
    {
        // Convert the input value to a Carbon instance for easier date comparison
        $inputDate = Carbon::parse($value);

        // Calculate the date 10 years ago from today
        $tenYearsAgo = now()->subYears(10);

        // Check if the input date is less than 10 years ago
        return $inputDate->lt($tenYearsAgo);
    }

    public function message()
    {
        $tenYearsAgo = now()->subYears(10)->format('Y'); // Get the year 10 years ago
        return 'The :attribute must be a date before ' . $tenYearsAgo;
    }
}
