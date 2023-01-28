<?php

namespace Intoy\HebatSupport\Validation\Rules;

class AlphaNum extends Rule
{

    /** @var string */
    protected $message = ":attribute hanya memungkinkan alfabet dan numerik";

    /**
     * Check the $value is valid
     *
     * @param mixed $value
     * @return bool
     */
    public function check($value): bool
    {
        if (! is_string($value) && ! is_numeric($value)) {
            return false;
        }

        return preg_match('/^[\pL\pM\pN]+$/u', $value) > 0;
    }
}
