<?php
declare (strict_types=1);

namespace Intoy\HebatSupport\Validation\Rules;

class Integer extends Rule 
{
    protected $message="harus sebagai angka";
    
    protected function validateValue($value, string $key): bool
    {
        if(is_null($value)) return true;
        $true=filter_var($value, FILTER_VALIDATE_INT) !== false;
        if($true)
        {
            $this->value=(int)$value;
            $this->modified=true;
        }        
        return $true;
    }    
}