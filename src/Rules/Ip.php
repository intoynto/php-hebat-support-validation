<?php

namespace Intoy\HebatSupport\Validation\Rules;

class Ip extends Rule
{

    /** @var string */
    protected $message = ":attribute bukan alamat IP yang valid";

    /**
     * Check the $value is valid
     *
     * @param mixed $value
     * @return bool
     */
    public function check($value): bool
    {
        return filter_var($value, FILTER_VALIDATE_IP) !== false;
    }
}
