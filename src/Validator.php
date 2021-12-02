<?php
declare (strict_types=1);

namespace Intoy\HebatSupport\Validation;

use Intoy\HebatSupport\Arr;
use Psr\Http\Message\ServerRequestInterface as Request;
use Intoy\HebatSupport\Validation\Rules\Rule;

class Validator {
    /**
     * Input 
     * @var Request|array
     */
    protected $input;   

    /**
     * Rules
     * @var array $rules
     */
    protected $rules=[];


    /**
     * Rules
     * @var array $alias
     */
    protected $alias=[];

    /**
     * Validators item by rule-rule
     * @var array 
     */
    protected $validators=[];

    /**
     * Stop Invalid
     * @var bool
     */
    protected $stopIsInvalid=false;


    /** @var array */
    protected $validData = [];

    /** @var array */
    protected $invalidData = [];

    /**
     * Get class Constructor Rule
     * @param string $rule
     * @return string|null
     */
    protected function getClassConstructorRule(string $rule)
    {
        $baseRules=[
            'alpha'=>Rules\Alpha::class,
            'coordinate'=>Rules\Coordinate::class,
            'date'=>Rules\Date::class,
            'date_indo'=>Rules\DateIndo::class,
            'dateindo'=>Rules\DateIndo::class,
            'digit'=>Rules\Digit::class,
            'email'=>Rules\Email::class,
            'in'=>Rules\In::class,
            'integer'=>Rules\Integer::class,
            'ip'=>Rules\Ip::class,
            'max'=>Rules\Max::class,
            'min'=>Rules\Min::class,
            'numeric'=>Rules\Numeric::class,
            'required'=>Rules\Required::class,
            'requiredif'=>Rules\RequiredIf::class,
            'required_if'=>Rules\RequiredIf::class,
            'requiredwith'=>Rules\RequiredWith::class,
            'required_with'=>Rules\RequiredWith::class,
            'same'=>Rules\Same::class,
        ];

        return isset($baseRules[$rule])?$baseRules[$rule]:null;
    }
    

    /**
     * Make | Run Validation
     * @param Request|array
     * @param array $rules
     * @param array $alias
     */
    public function make($input, array $rules, array $alias=[])
    {
        if(empty($rules))
        {
            throw new \InvalidArgumentException('Harus menyertakan rules.');
        }
        $this->input=$input; // store input

        $this->rules=$rules; // attach rules
        $this->alias=$alias; // attch alias

        $this->validators=[]; //reset
        $this->validData=[]; //reset 
        $this->invalidData=[]; // reset

        foreach($rules as $inputName => $string)
        {
            $name=is_numeric($inputName)?(string)$string:$inputName;
            $pola=is_numeric($inputName)?'':$string;
            $rules=$this->resolveRules($pola);
            $this->validators[$name]=$rules;
        }
    }

    /**
     * @param string $name
     * @param string $pola
     * @return array
     */
    protected function resolveRules(string $pola)
    {
        if(empty($pola))
        {
            return []; //empty rules
        }

        $explicitPath = $this->getLeadingExplicitAttributePath($pola);
        $rules = explode('|', $explicitPath);
        foreach($rules as $i => $rule)
        {
            if(empty($rule))
            {
                continue;
            }

            $params = [];
            if (is_string($rule)) {
                list($rulename, $params) = $this->parseRule($rule);
                $class=$this->getClassConstructorRule((string)$rulename);
                if(!$class)
                {
                    throw new \Exception(sprintf("Validator '%s' is not registered",$rulename));
                }
                $validator=$this->createRule($class);
                $validator->setParameters($params);
                $resolvedRules[]=$validator;
            }
            else {
                //thowable empty rules
            }
        }
        return $resolvedRules;
    }

    /**
     * Get the explicit part of the attribute name.
     * Adapted from: https://github.com/illuminate/validation/blob/v5.3.23/Validator.php#L2817
     *
     * E.g. 'foo.bar.*.baz' -> 'foo.bar'
     *
     * Allows us to not spin through all of the flattened data for some operations.
     *
     * @param  string  $attributeKey
     * @return string|null null when root wildcard
     */
    protected function getLeadingExplicitAttributePath(string $attributeKey)
    {
        return rtrim(explode('*', $attributeKey)[0], '.') ?: null;
    }


    /**
     * Parse $rule
     *
     * @param string $rule
     * @return array
     */
    protected function parseRule(string $rule): array
    {
        $exp = explode(':', $rule, 2);
        $rulename = $exp[0];
        if ($rulename !== 'regex') {
            $params = isset($exp[1])? explode(',', $exp[1]) : [];
        } else {
            $params = [$exp[1]];
        }

        return [$rulename, $params];
    }

    protected function createRule(string $constructor):Rule
    {
        return new $constructor($this);
    }


    public function validate()
    {
        if(empty($this->validators))
        {
            return;
        }

        foreach($this->validators as $key => $rules)
        {
            if(empty($rules))
            {
                $rule=new Rules\DefaultRule($this);
                $rule->validate($this->input,$key);
                $this->setValidValue($key,$rule);
                continue; //next loop
            }

            foreach($rules as $rule)
            {
                $valid=$rule->validate($this->input,$key);
                if(!$valid)
                {
                    $this->setNotValidValue($key, $rule);
                    break;
                }
                
                $this->setValidValue($key,$rule);
            }
        }
    }

    protected function setValidValue(string $key,Rule $rule)
    {
        $this->validData[$key]=$rule->getValue(); 
        if($rule->isModified()) 
        {
            $this->input[$key]=$rule->getValue();
        }
        Arr::forget($this->invalidData,$key);
    }

    public function getAliasKey(string $key)
    {
        $alias=Arr::get($this->alias,$key);
        $alias=$alias?$alias:ucfirst(implode(" ",explode("_",(string)$key)));
        return $alias;
    }

    protected function setNotValidValue(string $key,Rule $rule)
    {        
        $message=$this->getAliasKey($key)." ".$rule->getMessage();
        $this->invalidData[$key]=$message;
        Arr::forget($this->validData,$key);
    }


    public function getValidValue($key,$default=null)
    {
        return isset($this->validData[$key])?$this->validData[$key]:$default;
    }

    public function success():bool
    {
        return empty($this->invalidData);
    }

    public function failed():bool
    {
        return !$this->success();
    }

    public function fails():bool
    {
        return !$this->success();
    }

    public function getValidData()
    {
        return $this->validData;
    }

    public function getNotValidData()
    {
        return $this->invalidData;
    }

    public function getErrors()
    {
        return $this->invalidData;
    }
}