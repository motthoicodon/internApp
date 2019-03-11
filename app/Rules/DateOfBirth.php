<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use DateTime;

class DateOfBirth implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $currentYear = date("Y");
        $date = DateTime::createFromFormat("Y/m/d", $value);
        $year = $date->format("Y");

        if (($year + 60) >= $currentYear) {
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The age of member should be not older than 60 years.';
    }
}
