<?php

namespace Intoy\HebatSupport\Validation;

use Intoy\HebatSupport\Validation\Interfaces\{
    ValidationInterface,
    ValidatorInterface,
};

use Intoy\HebatSupport\Validation\Traits\{
    MessagesTrait,
    TranslationsTrait,
};

use Intoy\HebatSupport\Validation\Exceptions\{
    RuleNotFoundException,
    RuleQuashException,
};

use Intoy\HebatSupport\Validation\Rules\Rule;

class Validator implements ValidatorInterface
{
    use MessagesTrait, TranslationsTrait;

    /** @var array */
    protected $translations = [];

    /** @var array */
    protected $validators = [];

    /** @var bool */
    protected $allowRuleOverride = false;

    /** @var bool */
    protected $useHumanizedKeys = true;

    /**
     * Constructor     
     * @param array $messages
     * @return void
     */
    public function __construct($messages = [])
    {
        $this->messages = $messages;
        $this->registerBaseValidators();
    }


    /**
     * Get classname base validator
     * @return array
     */
    protected function getBaseValidators()
    {
        $baseValidators = [
            'alpha'             => Rules\Alpha::class,

            'alphadash'         => Rules\AlphaDash::class,
            'alpha_dash'        => Rules\AlphaDash::class,

            'alphaspace'        => Rules\AlphaSpaces::class,
            'alpha_space'       => Rules\AlphaSpaces::class,
            'alpha_spaces'      => Rules\AlphaSpaces::class,

            'alphanum'          => Rules\AlphaNum::class,
            'alpha_num'         => Rules\AlphaNum::class,

            'between'           => Rules\Between::class,
            'coordinate'        => Rules\Coordinate::class,
            'date'              => Rules\Date::class,
            'date_indo'         => Rules\DateIndo::class,
            'dateindo'          => Rules\DateIndo::class,
            'digit'             => Rules\Digits::class,
            'digits'            => Rules\Digits::class,
            'email'             => Rules\Email::class,
            'in'                => Rules\In::class,
            'integer'           => Rules\Integer::class,
            'ip'                => Rules\Ip::class,
            'ip4'               => Rules\Ipv4::class,
            'ip6'               => Rules\Ipv6::class,
            'json'              => Rules\Json::class,
            'lower'             => Rules\Lowercase::class,
            'lower_case'        => Rules\Lowercase::class,
            'lowercase'         => Rules\Lowercase::class,
            'max'               => Rules\Max::class,
            'min'               => Rules\Min::class,
            'notin'             => Rules\NotIn::class,
            'not_in'            => Rules\NotIn::class,
            'numeric'           => Rules\Numeric::class,
            'regex'             => Rules\Regex::class,
            'req'               => Rules\Required::class,
            'required'          => Rules\Required::class,
            'requiredif'        => Rules\RequiredIf::class,
            'required_if'       => Rules\RequiredIf::class,
            'requiredwith'      => Rules\RequiredWith::class,
            'required_with'     => Rules\RequiredWith::class,
            'same'              => Rules\Same::class,
            'totrim'            => Rules\ToTrim::class,
            'to_trim'           => Rules\ToTrim::class,
            'tonull'            => Rules\ToNull::class,
            'to_null'           => Rules\ToNull::class,
            'to_remove_space'   => Rules\ToRemoveSpace::class,
            'toremovespace'     => Rules\ToRemoveSpace::class,
            'upper'             => Rules\Uppercase::class,
            'upper_case'        => Rules\Uppercase::class,
            'uppercase'         => Rules\Uppercase::class,
            'url'               => Rules\Url::class,
        ];

        return $baseValidators;
    }

    /**
     * Initialize base validators array
     * @return void
     */
    protected function registerBaseValidators()
    {
        $baseValidator=$this->getBaseValidators();
        foreach ($baseValidator as $key => $validatorClass) {
            //$validator=new $validatorClass();
            $this->setValidator($key, $validatorClass);
        }
    }

    /**
     * Register or override existing validator
     * @param mixed $key
     * @param string|Rule $rule
     * @return void
     */
    public function setValidator($key, $rule)
    {
        $this->validators[$key] = $rule;
        //$rule->setKey($key); ??
    }

    /**
     * Get validator object from given $key
     * @param mixed $key
     * @return mixed
     */
    public function getValidator($key)
    {
        return isset($this->validators[$key]) ? $this->validators[$key] : null;
    }

    /**
     * Validate $inputs
     * @param array $inputs
     * @param array $rules
     * @param array $messages
     * @return Validation
     */
    public function validate($inputs, $rules, $messages = [])
    {
        $validation = $this->make($inputs, $rules, $messages);
        $validation->validate();
        return $validation;
    }

    /**
     * Given $inputs, $rules and $messages to make the Validation class instance
     * @param array $inputs
     * @param array $rules
     * @param array $messages
     * @return Validation
     */
    public function make($inputs, $rules, $messages = [])
    {
        $messages = array_merge($this->messages, $messages);
        $validation = new Validation($this, $inputs, $rules, $messages);
        $validation->setTranslations($this->getTranslations());

        return $validation;
    }

    /**
     * Magic invoke method to make Rule instance
     *
     * @param string $rule
     * @return Rule
     * @throws RuleNotFoundException
     */
    public function __invoke($rule)
    {
        $args = func_get_args();
        $rule = array_shift($args);
        $params = $args;
        $constract = $this->getValidator($rule);
        if (!$constract) 
        {
            throw new RuleNotFoundException("Validator '{$rule}' is not registered", 1);
        }

        $validator=$this->resolveRule($constract);
        if(!$validator)
        {
            throw new RuleNotFoundException("Validator '{$rule}' is not callable", 1);
        }

        $clonedValidator = clone $validator;
        $clonedValidator->fillParameters($params);

        return $clonedValidator;
    }

    /**
     * @param string|Rule
     * @return null|Rule
     */
    protected function resolveRule($rule)
    {
        if(is_object($rule)) return $rule;
        if(is_string($rule) && class_exists($rule)) 
        {
            $obj=new $rule();
            if(method_exists($obj,"setKey"))
            {
                $baseValidators=$this->getBaseValidators();
                $key=array_search($rule,$baseValidators);
                if($key && is_string($key))
                {
                    $key=ucwords((string)$key);
                    call_user_func_array([$obj,"setKey"],[$key]);
                }
            }
            return $obj;
        }
        return null;
    }


    /**
     * Given $ruleName and $rule to add new validator
     * @param string $ruleName
     * @param Rule $rule
     * @return void
     */
    public function addValidator($ruleName, $rule)
    {
        if (!$this->allowRuleOverride && array_key_exists($ruleName, $this->validators)) {
            throw new RuleQuashException(
                "You cannot override a built in rule. You have to rename your rule"
            );
        }

        $this->setValidator($ruleName, $rule);
    }


    /**
     * Set rule can allow to be overrided
     * @param boolean $status
     * @return void
     */
    public function allowRuleOverride($status = false)
    {
        $this->allowRuleOverride = $status;
    }


    /**
     * Set this can use humanize keys
     * @param boolean $useHumanizedKeys
     * @return void
     */
    public function setUseHumanizedKeys($useHumanizedKeys = true)
    {
        $this->useHumanizedKeys = $useHumanizedKeys;
    }

    /**
     * Get $this->useHumanizedKeys value
     * @return void
     */
    public function isUsingHumanizedKey(): bool
    {
        return $this->useHumanizedKeys;
    }
}