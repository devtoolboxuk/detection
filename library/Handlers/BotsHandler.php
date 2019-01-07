<?php

namespace aegis\detection\Handlers;

use aegis\detection\Wrappers\BotWrapper;

class BotsHandler extends Handler
{
    public function __construct($value = '')
    {
        parent::__construct($value);
        $this->setName(str_replace(__NAMESPACE__ . '\\', '', __CLASS__));
        $this->pushWrapper(new BotWrapper());
    }
}