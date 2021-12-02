<?php
declare (strict_types=1);

namespace Intoy\HebatSupport\Validation\Rules;

use Psr\Http\Message\ServerRequestInterface as Request;
use Intoy\HebatSupport\Validation\Validator;

abstract class Rule {
    
    /** @var array */
    protected $params = [];

    /**
     * fillableParams
     * @var array 
     */
    protected $fillableParams=[];   

    /**
     * Value
     */
    protected $value=null;


    /**
     * Array value PsrHttp Request -> getQueryParam or getParseBody
     * @var array $parseBody
     */
    protected $parseBody=[];

    /**
     * Param modify
     * @bool
     */
    protected $modified=false;


    /** @var string */
    protected $message = "tidak valid.";


    /**
     * @var Validator $validator
     */
    protected $validator;


    public function __construct(Validator $validator)
    {
        $this->validator=$validator;        
    }

    /**
     * Fill $params to $this->params
     *
     * @param array $params
     * @return Rule
     */
    public function setParameters(array $params): Rule
    {
        foreach ($this->fillableParams as $key) {
            if (empty($params)) 
            {
                break;
            }
            $this->params[$key] = array_shift($params);
        }
        return $this;
    }

    /**
     * @param Request|array
     */
    protected function requestParams($inputs)
    {
        if($inputs instanceof Request)        
        {
            return strtolower((string)$inputs->getMethod())==='get'?$inputs->getQueryParams():$inputs->getParsedBody();
        }
        elseif(is_array($inputs))
        {
            return $inputs;            
        }
        else {
            throw new \InvalidArgumentException(sprintf('Invalid %s request input. Request must be %s or array.',gettype($inputs),Request::class));
        }
    }


    protected function checkParameters(array $params)
    {
        foreach ($params as $param) 
        {
            if (!isset($this->params[$param])) {                
                throw new \InvalidArgumentException(sprintf("Missing required parameter '%s' on rule '%s'",$param,get_class($this)));
            }
        }
    }


    /**
     * @param Request|array $input
     * @param string $key
     * @return bool
     * @throws \InvalidArgumentException
     */
    public function validate($inputs,string $key):bool
    {
        
        $this->parseBody=$this->requestParams($inputs);
        $values=$this->parseBody;

        $this->modified=false;
        $isset=isset($values[$key]);
        $value=$isset?$values[$key]:$this->value; // null
        $valid=$this->validateValue($value, $key);
        if($valid && !$this->modified)
        {
            if(is_string($value))
            {
                $value=trim((string)$value);
            }
            $this->value=$value;
        }

        return $valid;
    }



    /**
     * @param string $key
     * @return bool 
     */
    protected function isEmptyValue($key)
    {
        $value=isset($this->parseBody[$key])?$this->parseBody[$key]:null;
        $rule=new Required($this->validator);
        return false===$rule->validateValue($value,$key);
    }


    /**
     * Get Is Modify value
     * @return boolean
     */
    public function isModified()
    {
        return $this->modified;
    }


    /**
     * @param mixed $value
     * @return bool
     */
    abstract protected function validateValue($value, string $key):bool;


    /**
     * Get parameter from given $key, return null if it not exists
     *
     * @param string $key
     * @return mixed
     */
    public function parameter(string $key)
    {
        return isset($this->params[$key])? $this->params[$key] : null;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getMessage()
    {
        return $this->message;
    }
}