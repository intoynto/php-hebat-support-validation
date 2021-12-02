<?php
declare (strict_types=1);

namespace Intoy\HebatSupport\Validation\Rules;

use Intoy\HebatSupport\Validation\Traits\SizeTrait;

class Min extends Rule 
{
    use SizeTrait;

    protected $fillableParams=['min'];

    protected function validateValue($value, string $key): bool
    {        
        if(is_null($value)) return true;        
        $min = $this->getBytesSize($this->parameter('min'));
        $valueSize = $this->getValueSize($value);

        if (!is_numeric($valueSize)) {
            return false;
        }

        $true=$valueSize >= $min;

        if(!$true)
        {
            $this->message="minimal ".$min." ";
        }

        return $true;
    }
}