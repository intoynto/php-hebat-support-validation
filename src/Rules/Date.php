<?php
declare (strict_types=1);

namespace Intoy\HebatSupport\Validation\Rules;

class Date extends Rule 
{
    protected $message="tanggal";
    
    /** @var array */
    protected $fillableParams = ['format'];

    /** @var array */
    protected $params=['format' => 'Y-m-d'];

    protected function validateValue($value, string $key): bool
    {
        if(is_null($value)) return true;
        $this->checkParameters($this->fillableParams);
        $format = $this->parameter('format');
        return date_create_from_format($format, $value) !== false;
    }
}