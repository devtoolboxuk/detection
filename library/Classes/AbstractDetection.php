<?php

namespace aegis\detection\classes;

abstract class AbstractDetection
{

    public $rules = [];

    protected $options = [];
    protected $results = [];
    protected $result = [];
    protected $score;

    protected $model;

    protected $resultType = 'json';

    public function __construct($options = [])
    {
        $this->options = $this->arrayMergeRecursiveDistinct($this->options, $options);
    }

    private function arrayMergeRecursiveDistinct($merged, $array2 = [])
    {
        if (empty($array2)) {
            return $merged;
        }

        foreach ($array2 as $key => &$value) {
            if (is_array($value) && isset($merged[$key]) && is_array($merged[$key])) {
                $merged[$key] = $this->arrayMergeRecursiveDistinct($merged[$key], $value);
            } else {
                $merged[$key] = $value;
            }
        }
        return $merged;
    }

    public function pushHandler($handler)
    {
        array_unshift($this->handlers, $handler);
        return $this;
    }

    public function getResult()
    {
        switch ($this->resultType) {
            case 'boolean':
                return ($this->score > 0) ? true : false;
                break;
            case 'json':
                return json_encode($this->result);
                break;
        }
    }

    public function check()
    {

        foreach ($this->handlers as $handler) {
            array_unshift($this->references, ['name' => $handler->getName(), 'value' => $handler->getValue()]);
            $this->processWrappers($handler);
        }

        return ($this->getScore() > 0) ? true : false;
    }


    protected function processWrappers($handler)
    {
        $options = $this->getOption('Detection');

        foreach ($handler->getWrappers() as $wrapper) {

            $wrapper->setOptions($handler->getValue(), $options['Rules']);
            $wrapper->process();
            $this->addResult($wrapper->getScore(), $wrapper->getResult());
        }
    }

    public function getOption($name)
    {
        if (!$this->hasOption($name)) {
            return null;
        }

        return $this->options[$name];
    }

    public function hasOption($name)
    {
        return isset($this->options[$name]);
    }

    protected function addResult($score, $result)
    {
        if (is_array($result)) {
            $this->addScore($score);
            $this->result = array_merge($this->result, $result);
        }
        return $this;
    }

    /**
     * Add Score
     * @param $score
     */
    private function addScore($score)
    {
        $this->score += $score;
    }

    /**
     * @return integer
     */
    public function getScore()
    {
        return $this->score;
    }

    protected function getOptions()
    {
        return $this->options;
    }


}