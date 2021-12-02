<?php
declare (strict_types=1);

namespace Intoy\HebatSupport\Validation\Rules;

class DefaultRule extends Rule 
{
    protected function validateValue($value, string $key): bool
    {
        return true;
    }
}