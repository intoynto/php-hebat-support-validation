<?php
declare (strict_types=1);

namespace Intoy\HebatSupport\Validation\Rules;


class Alpha extends Rule 
{
    protected $message="abjad huruf";
    
    protected function validateValue($value, string $key): bool
    {
        if (is_null($value)) return true;
        return is_string($value) && preg_match('/^[\pL\pM]+$/u', $value);
    }    
}