<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\Rule;

class OnlyGmail implements Rule
{

    public function passes($attribute, $value)
    {
        if(strpos($value, "@gmail.com") !== false)
        {
            return true;
        }
        return false;
    }

    public function message()
    {
        return "Please use a valid gmail account!";
    }

}
