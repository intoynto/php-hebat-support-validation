<?php

namespace Intoy\HebatSupport\Validation\Rules;

class Lowercase extends Rule
{

    /** @var string */
    protected $message = ":attribute harus huruf kecil";

    /**
     * Check the $value is valid
     *
     * @param mixed $value
     * @return bool
     */
    public function check($value): bool
    {
        return mb_strtolower($value, mb_detect_encoding($value)) === $value;
    }
}
