<?php

namespace Intoy\HebatSupport\Validation\Rules;

use Intoy\HebatSupport\Validation\Helper;

class In extends Rule
{

    /** @var string */
    protected $message = ":attribute hanya memungkinan :allowed_values";

    /** @var bool */
    protected $strict = false;

    /**
     * Given $params and assign the $this->params
     *
     * @param array $params
     * @return self
     */
    public function fillParameters($params)
    {
        if (count($params) == 1 && is_array($params[0])) {
            $params = $params[0];
        }
        $this->params['allowed_values'] = $params;
        return $this;
    }

    /**
     * Set strict value
     *
     * @param bool $strict
     * @return void
     */
    public function strict(bool $strict = true)
    {
        $this->strict = $strict;
    }

    /**
     * Check $value is existed
     *
     * @param mixed $value
     * @return bool
     */
    public function check($value): bool
    {
        $this->requireParameters(['allowed_values']);

        $allowedValues = $this->parameter('allowed_values');

        $or = $this->validation ? $this->validation->getTranslation('or') : 'or';
        $allowedValuesText = Helper::join(Helper::wraps($allowedValues, "'"), ', ', ", {$or} ");
        $this->setParameterText('allowed_values', $allowedValuesText);

        return in_array($value, $allowedValues, $this->strict);
    }
}
