<?php
declare (strict_types=1);

namespace Intoy\HebatSupport\Validation\Rules;

class RequiredWith extends Rule 
{
    public function setParameters(array $params): Rule
    {
        $this->params['field'] = $params;       
        return $this;    
    }

    protected function validateValue($value, string $key): bool
    {
        $this->checkParameters(['field']);
        $anotherAttribute = $this->parameter('field');

        $required=false;
        $val=null;
        foreach($anotherAttribute as $field)
        {
            $val=$this->validator->getValidValue($field);
            if(Required::isValueable($val))
            {
                $required=true;
                break;
            }
        }

        $true=$required?Required::isValueable($value):true;
        if(!$true)
        {
            $this->message='harus ikut disertakan';
        }
        return $true;
    }
}