<?php

namespace Intoy\HebatSupport\Validation\Rules;

class Integer extends Rule
{

    /** @var string */
    protected $message = ":attribute harus bilangan bulat";

    /**
     * Check the $value is valid
     *
     * @param mixed $value
     * @return bool
     */
    public function check($value): bool
    {
        return filter_var($value, FILTER_VALIDATE_INT) !== false;
    }
}
