<?php

namespace Intoy\HebatSupport\Validation\Rules;

use Intoy\HebatSupport\Validation\Interfaces\ModifyValue;

class Defaults extends Rule implements ModifyValue
{

    /** @var string */
    protected $message = ":attribute standarnya adalah :default";

    /** @var array */
    protected $fillableParams = ['default'];

    /**
     * Check the $value is valid
     *
     * @param mixed $value
     * @return bool
     */
    public function check($value): bool
    {
        $this->requireParameters($this->fillableParams);

        $default = $this->parameter('default');
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function modifyValue($value)
    {
        return $this->isEmptyValue($value) ? $this->parameter('default') : $value;
    }

    /**
     * Check $value is empty value
     *
     * @param mixed $value
     * @return boolean
     */
    protected function isEmptyValue($value): bool
    {
        $requiredValidator = new Required;
        return false === $requiredValidator->check($value, []);
    }
}
