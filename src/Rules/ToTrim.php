<?php

namespace Intoy\HebatSupport\Validation\Rules;

use Intoy\HebatSupport\Validation\Interfaces\ModifyValue;

class ToTrim extends ToBase implements ModifyValue
{
    public function modifyValue($value)
    {
        if(!$this->isEmpty($value))
        {
            if(is_string($value) || is_numeric($value))
            {
                // remove double space
                $value=preg_replace('/\s+/',' ',trim((string)$value));                
            }
        }

        return $value;
    }
}