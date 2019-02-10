<?php

namespace App\Base;

abstract class Singleton
{
    protected static function getInstance($initData = null)
    {
        static $object = array();

        $class = '\\' . static::class;

        if ( ! isset($object[$class])) {
            $object[$class] = new $class();
        }

        if ($initData !== null) {
            $object[$class]->init($initData);
        }

        return $object[$class];
    }

    public static function instance() : self
    {
        return static::getInstance();
    }

    abstract protected function init($initData);
}