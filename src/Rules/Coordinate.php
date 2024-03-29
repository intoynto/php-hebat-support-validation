<?php

namespace Intoy\HebatSupport\Validation\Rules;

class Coordinate extends Rule
{

    /** @var string */
    protected $message = "The :attribute harus numerik koordinat";

    /**
     * Check the $value is valid
     *
     * @param mixed $value
     * @return bool
     */
    public function check($value): bool
    {
        return is_numeric($value);
    }
}
