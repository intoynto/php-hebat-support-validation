<?php

namespace Intoy\HebatSupport\Validation\Rules;

use Intoy\HebatSupport\Validation\Exceptions\MissingRequiredParameterException;

abstract class Rule
{
    /** @var string */
    protected $key;

    /** @var \Intoy\HebatSupport\Validation\Attribute|null */
    protected $attribute;

    /** @var \Intoy\HebatSupport\Validation\Validation|null */
    protected $validation;

    /** @var bool */
    protected $implicit = false;

    /** @var array */
    protected $params = [];

    /** @var array */
    protected $paramsTexts = [];

    /** @var array */
    protected $fillableParams = [];

    /** @var string */
    protected $message = ":attribute tidak valid";

    abstract public function check($value): bool;

    /**
     * Set Validation class instance
     * @param \Intoy\HebatSupport\Validation\Validation $validation
     * @return void
     */
    public function setValidation($validation)
    {
        $this->validation = $validation;
    }

    /**
     * Set key
     * @param string $key
     * @return void
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * Get key
     * @return string
     */
    public function getKey()
    {
        return $this->key ?: get_class($this);
    }

    /**
     * Set attribute
     * @param \Intoy\HebatSupport\Validation\Attribute $attribute
     * @return void
     */
    public function setAttribute($attribute)
    {
        $this->attribute = $attribute;
    }

    /**
     * Get attribute
     *
     * @return \Intoy\HebatSupport\Validation\Attribute|null
     */
    public function getAttribute()
    {
        return $this->attribute;
    }

    /**
     * Get parameters
     * @return array
     */
    public function getParameters()
    {
        return $this->params;
    }

    /**
     * Set params
     * @param array $params
     * @return \Intoy\HebatSupport\Validation\Rule
     */
    public function setParameters(array $params)
    {
        $this->params = array_merge($this->params, $params);
        return $this;
    }

    /**
     * Set parameters
     * @param string $key
     * @param mixed $value
     * @return \Intoy\HebatSupport\Validation\Rule
     */
    public function setParameter(string $key, $value)
    {
        $this->params[$key] = $value;
        return $this;
    }

    /**
     * Fill $params to $this->params
     * @param array $params
     * @return \Intoy\HebatSupport\Validation\Rule
     */
    public function fillParameters($params)
    {
        foreach ($this->fillableParams as $key) {
            if (empty($params)) {
                break;
            }
            $this->params[$key] = array_shift($params);
        }
        return $this;
    }

    /**
     * Get parameter from given $key, return null if it not exists
     * @param string $key
     * @return mixed
     */
    public function parameter($key)
    {
        return isset($this->params[$key])? $this->params[$key] : null;
    }

    /**
     * Set parameter text that can be displayed in error message using ':param_key'
     * @param string $key
     * @param string $text
     * @return void
     */
    public function setParameterText($key, $text)
    {
        $this->paramsTexts[$key] = $text;
    }

    /**
     * Get $paramsTexts
     * @return array
     */
    public function getParametersTexts()
    {
        return $this->paramsTexts;
    }

    /**
     * Check whether this rule is implicit
     * @return boolean
     */
    public function isImplicit()
    {
        return $this->implicit;
    }

    /**
     * Just alias of setMessage
     * @param string $message
     * @return \Intoy\HebatSupport\Validation\Rule
     */
    public function message($message)
    {
        return $this->setMessage($message);
    }

    /**
     * Set message
     * @param string $message
     * @return \Intoy\HebatSupport\Validation\Rule
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * Get message
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Check given $params must be exists
     *
     * @param array $params
     * @return void
     * @throws \Intoy\HebatSupport\Validation\MissingRequiredParameterException
     */
    protected function requireParameters($params)
    {
        foreach ($params as $param) {
            if (!isset($this->params[$param])) {
                $rule = $this->getKey();
                throw new MissingRequiredParameterException("Missing required parameter '{$param}' on rule '{$rule}'");
            }
        }
    }
}
