<?php

namespace dolos\detection\Wrappers;

class QueryStringValueWrapper extends Wrapper
{

    private $query_array = [];

    public function process()
    {
        $this->initWrapper($this->setLocalName());

        $this->getQueryString();

        list($key, $value) = array_pad(explode('|', $this->getReference()), 2, null);

        if (isset($this->query_array[$key])) {
            if ($this->query_array[$key] == $value) {
                $this->setScore($this->getRealScore());
                $this->setResult();
            }
        }
    }

    private function setLocalName()
    {
        $name = str_replace(__NAMESPACE__ . '\\', '', __CLASS__);
        return str_replace('Wrapper', '', $name);
    }


    private function getQueryString()
    {
        if (isset($_SERVER["QUERY_STRING"])) {
            parse_str($_SERVER["QUERY_STRING"], $this->query_array);
        }
    }

}