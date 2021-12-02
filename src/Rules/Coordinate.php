<?php
declare (strict_types=1);

namespace Intoy\HebatSupport\Validation\Rules;


class Coordinate extends Rule 
{
    protected $message="format koordinat tidak valid";

    protected function validateValue($value, string $key): bool
    {
        if(is_null($value)) return true;
        if(is_string($value) && $value==='') return true;
                
        if(!is_string($value)) return false;

        $value=trim((string)$value);
        $value=explode(',',$value);
        $lat=$value[0];

        if(!isset($value[1])) return false;

        $lon=$value[1];
        $lat=floatval($lat);
        $lon=floatval($lon);

        $valid_lat=$lat<=90 && $lat>=-90;
        $valid_lon=$lon<=180 && $lon>=-180;

        if(!$valid_lat)
        {
            $this->message="latitude tidak valid";
            return false;
        }

        if(!$valid_lon)
        {
            $this->message="longitude tidak valid";
        }

        $this->value=$lat.",".$lon;
        $this->modified=true;
        return true;
    }
}