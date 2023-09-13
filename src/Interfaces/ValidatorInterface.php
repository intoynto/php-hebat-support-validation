<?php
declare (strict_types=1);

namespace Intoy\HebatSupport\Validation\Interfaces;

use Intoy\HebatSupport\Validation\Rules\Rule;
use Intoy\HebatSupport\Validation\Interfaces\ValidationInterface;

interface ValidatorInterface 
{
    /**
     * Register or override existing validator
     * @param mixed $key
     * @param string|Rule $rule
     * @return void
     */
    public function setValidator($key, $rule);


    /**
     * Get validator object from given $key
     * @param mixed $key
     * @return mixed
     */
    public function getValidator($key);


    /**
     * Validate $inputs
     * @param array $inputs
     * @param array $rules
     * @param array $messages
     * @return ValidationInterface
     */
    public function validate($inputs, $rules, $messages = []);


    /**
     * Given $inputs, $rules and $messages to make the Validation class instance
     * @param array $inputs
     * @param array $rules
     * @param array $messages
     * @return ValidationInterface
     */
    public function make($inputs, $rules, $messages = []);


    /**
     * Given $ruleName and $rule to add new validator
     * @param string $ruleName
     * @param Rule $rule
     * @return void
     */
    public function addValidator($ruleName, $rule);


    /**
     * Set rule can allow to be overrided
     * @param boolean $status
     * @return void
     */
    public function allowRuleOverride($status = false);


    /**
     * Set this can use humanize keys
     * @param boolean $useHumanizedKeys
     * @return void
     */
    public function setUseHumanizedKeys($useHumanizedKeys = true);


    /**
     * Get $this->useHumanizedKeys value
     * @return bool|null
     */
    public function isUsingHumanizedKey();
}