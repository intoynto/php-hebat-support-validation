<?php

namespace Intoy\HebatSupport\Validation\Rules;

class Uppercase extends Rule
{

    /** @var string */
    protected $message = ":attribute harus huruf besar";

    /**
     * Check the $value is valid
     *
     * @param mixed $value
     * @return bool
     */
    public function check($value): bool
    {
        return mb_strtoupper($value, mb_detect_encoding($value)) === $value;
    }
}
