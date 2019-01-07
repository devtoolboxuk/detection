<?php

namespace aegis\detection\Handlers;

use aegis\detection\Wrappers\DisposableEmailWrapper;
use aegis\detection\Wrappers\EmailWrapper;

class EmailHandler extends Handler
{
    public function __construct($value = '')
    {
        parent::__construct($value);
        $this->setName(str_replace(__NAMESPACE__ . '\\', '', __CLASS__));

        $this->pushWrapper(new DisposableEmailWrapper());
        $this->pushWrapper(new EmailWrapper());
    }
}