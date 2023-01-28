<?php

namespace Intoy\HebatSupport\Validation\Rules;

use Intoy\HebatSupport\Validation\Interfaces\ModifyValue;

class ToNull extends ToBase implements ModifyValue
{
    public function modifyValue($value)
    {
        if($this->isEmpty($value))
        {
            if(is_string($value) && strlen(trim((string)$value))<1)
            {
                $value=null;
            }
        }

        return $value;
    }
}