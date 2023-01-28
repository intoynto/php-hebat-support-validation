<?php

namespace Intoy\HebatSupport\Validation\Rules;

class Same extends Rule
{

    /** @var string */
    protected $message = ":attribute harus sama dengan :field";

    /** @var array */
    protected $fillableParams = ['field'];

    /**
     * Check the $value is valid
     *
     * @param mixed $value
     * @return bool
     */
    public function check($value): bool
    {
        $this->requireParameters($this->fillableParams);

        $field = $this->parameter('field');       
        
        $anotherValue = $this->getAttribute()->getValue($field);

        $true=$value == $anotherValue;

        if(!$true)
        {
            $alias=$this->validation->getAlias($field);
            if($alias)
            {
                $this->message=str_replace(":field",$alias,$this->message);
            }
        }

        return $true;
    }
}
