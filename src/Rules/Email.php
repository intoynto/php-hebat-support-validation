<?php

namespace Intoy\HebatSupport\Validation\Rules;

class Email extends Rule
{

    /** @var string */
    protected $message = ":attribute tidak valid sebagai email";

    /**
     * Check $value is valid
     *
     * @param mixed $value
     * @return bool
     */
    public function check($value): bool
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }
}
