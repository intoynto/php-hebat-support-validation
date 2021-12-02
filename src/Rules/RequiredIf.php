<?php
declare (strict_types=1);

namespace Intoy\HebatSupport\Validation\Rules;

class RequiredIf extends Rule 
{
    protected $message="harus diisi";

    public function setParameters(array $params): Rule
    {
        $this->params['field'] = array_shift($params);
        $this->params['values'] = $params;
        return $this;    
    }

    protected function validateValue($value, string $key): bool
    {
        $this->checkParameters(['field', 'values']);
        $anotherAttribute = $this->parameter('field');
        $definedValues = $this->parameter('values');
        $anotherValue = $this->validator->getValidValue($anotherAttribute);
        $required=in_array($anotherValue, $definedValues);
        $true=$required?Required::isValueable($value):true;
        return $true;
    }
}