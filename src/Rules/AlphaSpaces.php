<?php

namespace Intoy\HebatSupport\Validation\Rules;

class AlphaSpaces extends Rule
{

    /** @var string */
    protected $message = ":attribute mungkin hanya mengizinkan alfabet dan spasi";

    /**
     * Check the $value is valid
     *
     * @param mixed $value
     * @return bool
     */
    public function check($value): bool
    {
        if (! is_string($value)) {
            return false;
        }

        return preg_match('/^[\pL\pM\s]+$/u', $value) > 0;
    }
}
