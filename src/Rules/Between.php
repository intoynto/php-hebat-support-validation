<?php

namespace Intoy\HebatSupport\Validation\Rules;

use Intoy\HebatSupport\Validation\Traits\SizeTrait;

class Between extends Rule
{
    use SizeTrait;

    /** @var string */
    protected $message = ":attribute harus antara :min dan :max";

    /** @var array */
    protected $fillableParams = ['min', 'max'];

    /**
     * Check the $value is valid
     *
     * @param mixed $value
     * @return bool
     */
    public function check($value): bool
    {
        $this->requireParameters($this->fillableParams);

        $min = $this->getBytesSize($this->parameter('min'));
        $max = $this->getBytesSize($this->parameter('max'));

        $valueSize = $this->getValueSize($value);

        if (!is_numeric($valueSize)) {
            return false;
        }

        return ($valueSize >= $min && $valueSize <= $max);
    }
}
