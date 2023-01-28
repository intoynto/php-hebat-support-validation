<?php

namespace Intoy\HebatSupport\Validation\Rules;

class Alpha extends Rule
{

    /** @var string */
    protected $message = ":attribute hanya mengizinkan karakter alfabet";

    /**
     * Check the $value is valid
     *
     * @param mixed $value
     * @return bool
     */
    public function check($value): bool
    {
        return is_string($value) && preg_match('/^[\pL\pM]+$/u', $value);
    }
}
