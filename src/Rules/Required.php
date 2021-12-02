<?php
declare (strict_types=1);

namespace Intoy\HebatSupport\Validation\Rules;

class Required extends Rule 
{
    /** @var string */
    protected $message = "harus diisi";
    
    public static function isValueable($value):bool
    {
        if((is_null($value) || $value === '' && $value === null))
        {
            return false;
        }

        if (is_string($value)) {
            return mb_strlen(trim($value), 'UTF-8') > 0;
        }
        if (is_array($value)) {
            return count($value) > 0;
        }

        return !is_null($value);
    }    

    protected function validateValue($value, string $key): bool
    {
        return static::isValueable($value);
    }
}