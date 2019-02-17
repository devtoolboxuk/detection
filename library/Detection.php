<?php

namespace dolos\detection;

/**
 * @method static Detection detect()
 */
class Detection
{
    protected static $factory;
    protected static $options = null;

    function __construct()
    {
        if (!static::$options) {
            static::setOptions();
        }
    }

    /**
     * @param array $options
     * @param string $file
     */
    public static function setOptions($options = [], $file = '')
    {

        $basic_options = yaml_parse_file(__DIR__ . '/Options.yml');
        $options = static::arrayMergeRecursiveDistinct($basic_options, $options);

        if ($file != '') {
            $other_options = yaml_parse_file($file);
            $options = static::arrayMergeRecursiveDistinct($other_options, $options);
        }
        
        static::$options = $options;
    }

    private static function arrayMergeRecursiveDistinct($merged, $array2 = [])
    {
        if (empty($array2)) {
            return $merged;
        }

        foreach ($array2 as $key => &$value) {
            if (is_array($value) && isset($merged[$key]) && is_array($merged[$key])) {
                $merged[$key] = static::arrayMergeRecursiveDistinct($merged[$key], $value);
            } else {
                $merged[$key] = $value;
            }
        }
        return $merged;
    }

    /**
     * @return mixed
     */
    public static function create()
    {
        $ref = new ReflectionClass(__CLASS__);
        return $ref->newInstance(func_get_args());
    }

    /**
     * @param $ruleName
     * @param array $arguments
     * @return object
     */
    public static function __callStatic($ruleName, $arguments = [])
    {
        $validator = new static();
        return $validator->__call($ruleName, $arguments);
    }

    /**
     * @param $method
     * @param $arguments
     * @return object
     * @throws \Exception
     */
    public function __call($method, $arguments)
    {
        return static::buildSecurity($method);
    }

    /**
     * @param $ruleSpec
     * @return object
     * @throws \Exception
     */
    public static function buildSecurity($ruleSpec)
    {
        try {
            return static::getFactory()->build($ruleSpec, static::$options);
        } catch (\Exception $exception) {
            throw new \Exception($exception);
        }
    }

    /**
     * @return Factory
     */
    protected static function getFactory()
    {
        if (!static::$factory instanceof Factory) {
            static::$factory = new Factory();
        }

        return static::$factory;
    }

    /**
     * @param Factory $factory
     */
    public static function setFactory($factory)
    {
        static::$factory = $factory;
    }
}
