<?php

namespace Intoy\HebatSupport\Validation\Rules;

use DateTime;
use Intoy\HebatSupport\Validation\Interfaces\ModifyValue;

class DateIndo extends Date implements ModifyValue
{
    /**
     * @return bool
     */
    protected function isEmpty($value)
    {
        return is_null($value) || empty($value) || $value==="" || 
              ((is_numeric($value) || is_string($value)) && strlen(trim((string)$value))<1);
    }

    /**
     * Modify given value
     * so in current and next rules returned value will be used
     *
     * @param mixed $value
     * @return mixed
     */
    public function modifyValue($value)
    {
        if(!$this->isEmpty($value))
        {
            $format="d.m.Y";
            $newValue=date_create_from_format($format, $value);
            $true=$newValue!==false;
            if($true && $newValue instanceof DateTime)
            {
                $format=(string)array_values($this->params)[0];
                $format=$format??"Y-m-d";
                $value=$newValue->format("Y-m-d");
            }
        }

        return $value;
    }
}