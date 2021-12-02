<?php
declare (strict_types=1);

namespace Intoy\HebatSupport\Validation\Rules;

use Intoy\HebatSupport\Validation\Traits\SizeTrait;

class Max extends Rule 
{
    use SizeTrait;

    protected $fillableParams=['max'];

    protected function validateValue($value, string $key): bool
    {
        if(is_null($value)) return true;        
        $max = $this->getBytesSize($this->parameter('max'));
        $valueSize = $this->getValueSize($value);

        if (!is_numeric($valueSize)) 
        {
            return false;
        }

        $isOver=$valueSize>$max;

        if($isOver)
        {
            $this->message="{$valueSize} melebihi  panjang maximum ".$max."";
            return false;
        }

        return true;       
    }
}