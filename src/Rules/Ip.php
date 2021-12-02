<?php
declare (strict_types=1);

namespace Intoy\HebatSupport\Validation\Rules;

class Ip extends Rule 
{
    protected function validateValue($value, string $key): bool
    {
        if(is_null($value)) return true;
        return filter_var($value, FILTER_VALIDATE_IP) !== false;
    }
}