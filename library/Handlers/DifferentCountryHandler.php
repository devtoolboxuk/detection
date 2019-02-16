<?php

namespace dolos\detection\Handlers;

use dolos\detection\Wrappers\DifferentCountryWrapper;

class DifferentCountryHandler extends Handler
{
    public function __construct($value = '')
    {
        parent::__construct($value);
        $this->setName(str_replace(__NAMESPACE__ . '\\', '', __CLASS__));
        $this->pushWrapper(new DifferentCountryWrapper());
    }
}