<?php

namespace Intoy\HebatSupport\Validation\Rules;

class RequiredWith extends Required
{
    /** @var bool */
    protected $implicit = true;

    /** @var string */
    protected $message = ":attribute harus diisi";

    /**
     * Given $params and assign $this->params
     *
     * @param array $params
     * @return self
     */
    public function fillParameters($params)
    {
        $this->params['fields'] = $params;
        return $this;
    }

    /**
     * Check the $value is valid
     *
     * @param mixed $value
     * @return bool
     */
    public function check($value): bool
    {
        $this->requireParameters(['fields']);
        $fields = $this->parameter('fields');
        $validator = $this->validation->getValidator();
        $requiredValidator = $validator('required');

        foreach ($fields as $field) {
            if ($this->validation->hasValue($field)) {
                $this->setAttributeAsRequired();
                return $requiredValidator->check($value, []);
            }
        }

        return true;
    }
}
