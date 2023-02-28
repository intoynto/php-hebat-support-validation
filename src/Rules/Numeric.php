<?php

namespace Intoy\HebatSupport\Validation\Rules;

class Numeric extends Rule
{

    /** @var string */
    protected $message = ":attribute harus numerik";

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
