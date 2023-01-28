<?php

namespace Intoy\HebatSupport\Validation\Rules;

class AlphaDash extends Rule
{

    /** @var string */
    protected $message = ":attribute hanya memungkinkan a-z, 0-9, _ dan -";

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

        return preg_match('/^[\pL\pM\pN_-]+$/u', $value) > 0;
    }
}
