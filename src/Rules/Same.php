<?php
declare (strict_types=1);

namespace Intoy\HebatSupport\Validation\Rules;

class Same extends Rule 
{
    /** @var array */
    protected $fillableParams = ['field'];

    protected function validateValue($value, string $key): bool
    {
        $field = $this->parameter('field');
        $anotherValue=$this->validator->getValidValue($field);

        $true=$value==$anotherValue;
        if(!$true) {
            $this->message="harus sesuai dengan ".$this->validator->getAliasKey($field);
        }

        return $true;
    }
}