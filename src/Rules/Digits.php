<?php

namespace Intoy\HebatSupport\Validation\Rules;

class Digits extends Rule
{

    /** @var string */
    protected $message = ":attribute harus numerik dan memiliki panjang yang tepat :length";

    /** @var array */
    protected $fillableParams = ['length'];

    /**
     * Check the $value is valid
     *
     * @param mixed $value
     * @return bool
     */
    public function check($value): bool
    {
        $this->requireParameters($this->fillableParams);

        $length = (int) $this->parameter('length');

        return !preg_match('/[^0-9]/', $value) && strlen((string) $value) == $length;
    }
}
