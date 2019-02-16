<?php

namespace dolos\detection\Wrappers;

class ZipWrapper extends Wrapper
{

    private $detected = 0;

    public function process()
    {
        $this->initWrapper($this->setLocalName());

        $this->detect();

        if ($this->detected > 0) {
            $this->setScore($this->getRealScore());
            $this->setResult();
        }
    }

    private function setLocalName()
    {
        $name = str_replace(__NAMESPACE__ . '\\', '', __CLASS__);
        return str_replace('Wrapper', '', $name);
    }


    private function detect()
    {
        $params = $this->getParams();
        if ($params) {
            foreach ($params as $param) {
                if ($param) {
                    if (strpos(strtolower($this->sanitizeReference()), $param) !== false) {
                        $this->detected++;
                    }
                }
            }
        }
    }

}