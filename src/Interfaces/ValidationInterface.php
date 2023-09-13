<?php
declare (strict_types=1);

namespace Intoy\HebatSupport\Validation\Interfaces;

use Intoy\HebatSupport\Validation\Interfaces\ValidatorInterface;
use Intoy\HebatSupport\Validation\Interfaces\ErrorBagInterface;
use Intoy\HebatSupport\Validation\Attribute;

interface ValidationInterface
{
    /**
     * Constructor 
     * @param ValidatorInterface $validator
     * @param array $inputs
     * @param array $rules
     * @param array $messages
     */
    public function __construct(ValidatorInterface $validator, array $inputs, array $rules, array $messages = []);

    /**
     * Add attribute rules
     * @param string $attributeKey
     * @param string|array $rules
     * @return void
     */
    public function addAttribute($attributeKey, $rules);

    /**
     * Get attribute by key
     *
     * @param string $attributeKey
     * @return null|Attribute
     */
    public function getAttribute($attributeKey);


    /**
     * Run validation
     * @param array $inputs
     * @return void
     */
    public function validate($inputs = []);

    /**
     * Get ErrorBag instance
     * @return ErrorBagInterface
     */
    public function errors();


    /**
     * Get all of the exact attribute values for a given wildcard attribute.
     * Adapted from: https://github.com/illuminate/validation/blob/v5.3.23/Validator.php#L354
     *
     * @param  array  $data
     * @param  string  $attributeKey
     * @return array
     */
    public function extractValuesForWildcards($data, $attributeKey);


    /**
     * Given $attributeKey and $alias then assign alias
     * @param mixed $attributeKey
     * @param mixed $alias
     * @return void
     */
    public function setAlias($attributeKey, $alias);

    /**
     * Get attribute alias from given key
     * @param mixed $attributeKey
     * @return string|null
     */
    public function getAlias($attributeKey);

    /**
     * Set attributes aliases
     * @param array $aliases
     * @return void
     */
    public function setAliases($aliases);

    /**
     * Check validations are passed
     * @return bool
     */
    public function passes();


    /**
     * Check validations are failed
     * @return bool
     */
    public function fails();


    /**
     * @return bool
     */
    public function failed();


    /**
     * Given $key and get value
     * @param string $key
     * @return mixed
     */
    public function getValue($key);


    /**
     * Set input value
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function setValue($key, $value);


     /**
     * Given $key and check value is exsited
     * @param string $key
     * @return boolean
     */
    public function hasValue($key);

    /**
     * Get Validator class instance
     * @return ValidatorInterface
     */
    public function getValidator():ValidatorInterface;


    /**
     * Get validated data
     * @return array
     */
    public function getValidatedData();


     /**
     * Get valid data
     * @return array
     */
    public function getValidData();


    /**
     * Get invalid data
     * @return array
     */
    public function getInvalidData();


    /**
     * Get invalid data
     * @return array
     */
    public function getNotValidData();


    /**
     * Get invalid pushed rules
     * @return array|null
     */
    public function getInputErrors();
}