<?php

namespace Intoy\HebatSupport\Validation\Rules;

class Regex extends Rule
{
    /**
     * Contoh penggunaan
     * regex:/your_regex/
     */

    /** @var string */
    protected $message = "format :attribute tidak valid";

    /** @var array */
    protected $fillableParams = ['regex'];

    /**
     * Check the $value is valid
     *
     * @param mixed $value
     * @return bool
     */
    public function check($value): bool
    {
        $this->requireParameters($this->fillableParams);
        $regex = $this->parameter('regex');
        return preg_match($regex, $value) > 0;
    }
}
