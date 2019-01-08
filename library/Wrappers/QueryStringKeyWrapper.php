<?php

namespace aegis\detection\Wrappers;

class QueryStringKeyWrapper extends Wrapper
{

    private $query_array;

    public function process()
    {
        $this->initWrapper($this->setLocalName());

        $this->getQueryString();

        list($key) = array_pad(explode('|', $this->getReference()), 1, null);

        if (isset($this->query_array[$key])) {
            $this->setScore($this->getRealScore());
            $this->setResult();
        }
    }

    private function setLocalName()
    {
        $name = str_replace(__NAMESPACE__ . '\\', '', __CLASS__);
        return str_replace('Wrapper', '', $name);
    }

    private function getQueryString()
    {
        parse_str($_SERVER["QUERY_STRING"], $this->query_array);
    }

}