<?php

namespace dolos\detection\Wrappers;

class NumericWrapper extends Wrapper
{
    
    public function process()
    {
        $this->initWrapper($this->setLocalName());

        if (is_numeric($this->getReference())) {
            $this->setScore($this->getRealScore());
            $this->setResult();
        }
    }

    private function setLocalName()
    {
        $name = str_replace(__NAMESPACE__ . '\\', '', __CLASS__);
        return str_replace('Wrapper', '', $name);
    }
}