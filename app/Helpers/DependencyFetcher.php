<?php

namespace App\Helpers;

class DependencyFetcher
{
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function fetch()
    {
        switch ($this->value) {
            case "category" :
                return $this->format($this->value);
                break;
            case "loans" :
                return $this->format($this->value);
                break;
            case "services" :
                return $this->format($this->value);
                break;
            default :
                return $this->format("payment");
        }
    }

    private function format($val)
    {
        return config('corporative.'.$val);
    }
}
