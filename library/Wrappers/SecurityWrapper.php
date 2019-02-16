<?php

namespace dolos\detection\Wrappers;

class SecurityWrapper extends Wrapper
{

    private $active = 0;

    private $reg_SQL = "/(drop|insert|md5|select|union)/i";

    private $reg_JS = "/(javascript|expression|ｅｘｐｒｅｓｓｉｏｎ|view-source|vbscript|jscript|wscript|vbs|script|base64|applet|alert|document|write|cookie|window|confirm|prompt|eval\()/i";

    public function process()
    {
        $this->initWrapper($this->setLocalName());

        $this->sqlDetection();
        $this->jsDetection();

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

    private function jsDetection()
    {
        if (preg_match($this->reg_JS, $this->getReference())) {
            $this->setLocalName('eval');
            $this->active = 1;
        }
    }

}