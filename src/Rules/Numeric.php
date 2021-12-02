<?php
declare (strict_types=1);

namespace Intoy\HebatSupport\Validation\Rules;

class Numeric extends Rule 
{
    protected $message="sebagai angka";
    
    protected function validateValue($value, string $key): bool
    {
        if(is_null($value)) return true;
        $true=is_numeric($value);
        $stringify=is_string($value);
        if($true)
        {
            $this->value=floatval($value);
            $this->modified=true;
        }
        elseif($stringify && trim((string)$value)<1)
        {
            $this->value=null;
            $this->modified=true;
            $true=true;
        }
        return $true;
    }
}