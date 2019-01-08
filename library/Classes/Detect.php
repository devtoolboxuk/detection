<?php

namespace dolos\detection\classes;

use dolos\detection\handlers\Handler;

class Detect extends AbstractDetection
{
    protected $handlers = [];
    protected $references = [];

    function __construct($options = [])
    {
        parent::__construct($options);
    }

    public function __call($method, $arguments = [])
    {
        $handlers = new Handler($arguments);
        $handler = $handlers->build($method, $arguments);
        $this->pushHandler($handler);
        return $this;
    }

    public function toArray()
    {
        return [
            'result_array' => (array)json_decode($this->getResult()),
            'result_string' => $this->getResult(),
            'References' => $this->references,
            'score' => $this->getScore()
        ];
    }
}