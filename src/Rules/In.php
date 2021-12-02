<?php
declare (strict_types=1);

namespace Intoy\HebatSupport\Validation\Rules;

class In extends Rule 
{
    protected $fillableParams=['allowed_values'];

    public function setParameters(array $params): Rule
    {
        if (count($params) == 1 && is_array($params[0])) {
            $params = $params[0];
        }
        $this->params['allowed_values'] = $params;
        return $this;
    }

    protected function validateValue($value, string $key): bool
    {
        if(is_null($value)) return true;
        $this->checkParameters(['allowed_values']);
        $allowedValues =(array)$this->parameter('allowed_values');
        $true=in_array($value, $allowedValues);
        if(!$true)
        {
            $this->message="yang diperbolehkan hanya (".implode(", ",$allowedValues).")";
        }
        return $true;
    }
}