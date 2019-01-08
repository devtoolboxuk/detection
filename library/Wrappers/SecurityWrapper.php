<?php

namespace dolos\detection\Wrappers;

class SecurityWrapper extends Wrapper
{

    private $active = 0;

    private $reg_SQL = "/(drop|insert|md5|select|union)/i";
    private $reg_EVAL = "/(eval\()/i";

    public function process()
    {
        $this->initWrapper($this->setLocalName());

        $this->sqlDetection();
        $this->evalDetection();

        if ($this->active == 1) {
            $this->setScore($this->getRealScore());
            $this->setResult();
        }
    }

    private function setLocalName()
    {
        $name = str_replace(__NAMESPACE__ . '\\', '', __CLASS__);
        return str_replace('Wrapper', '', $name);
    }


    private function sqlDetection()
    {
        if (preg_match($this->reg_SQL, $this->getReference())) {
            $this->setLocalName('sql');
            $this->active = 1;
        }
    }

    private function evalDetection()
    {
        if (preg_match($this->reg_EVAL, $this->getReference())) {
            $this->setLocalName('eval');
            $this->active = 1;
        }
    }

}