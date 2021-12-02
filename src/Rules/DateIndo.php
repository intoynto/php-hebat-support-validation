<?php
declare (strict_types=1);

namespace Intoy\HebatSupport\Validation\Rules;


class DateIndo extends Rule 
{
    protected $message='tidak valid format tanggal';
    
    /** @var array */
    protected $fillableParams = ['format'];

    /** @var array */
    protected $params=['format' => 'd.m.Y'];

    protected function validateValue($value, string $key): bool
    {
        if(is_null($value) || strlen(trim((string)$value))<1) 
        {
            $this->value=null;
            $this->modified=true;
            return true;
        };
        
        $this->checkParameters($this->fillableParams);
        $format = $this->parameter('format');
        $newValue=date_create_from_format($format, $value);
        $true=$newValue!== false;
        if($true)
        {
            $this->value=$newValue->format('Y-m-d');
            $this->modified=true;            
        }
        return $true;
    }
}