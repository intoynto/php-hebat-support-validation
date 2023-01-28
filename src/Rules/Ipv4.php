<?php

namespace Intoy\HebatSupport\Validation\Rules;

class Ipv4 extends Rule
{

    /** @var string */
    protected $message = ":attribute bukan Alamat IPv4 yang valid";

    /**
     * Check the $value is valid
     *
     * @param mixed $value
     * @return bool
     */
    public function check($value): bool
    {
        return filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) !== false;
    }
}
