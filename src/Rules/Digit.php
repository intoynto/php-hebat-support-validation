<?php
declare (strict_types=1);

namespace Intoy\HebatSupport\Validation\Rules;

class Digit extends Rule 
{
    protected $message="tidak valid sebagai digit.";

    protected function validateValue($value, string $key): bool
    {
        if(is_null($value)) return true;        
        return is_string($value) && ctype_digit($value);
    }
}