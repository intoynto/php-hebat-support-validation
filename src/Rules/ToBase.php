<?php

namespace Intoy\HebatSupport\Validation\Rules;

class ToBase extends Rule
{
    /** @var string */
    protected $message = ":attribute hanya mengizinkan string atau numerik";
    
    /**
     * @return bool
     */
    protected function isEmpty($value)
    {
        return is_null($value) || empty($value) || $value==="" || 
              ((is_numeric($value) || is_string($value)) && strlen(trim((string)$value))<1);
    }

    public function check($value): bool
    {
        return $this->isEmpty($value);
    }
}