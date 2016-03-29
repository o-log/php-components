<?php

namespace OLOG\Component;

/**
 * Created by PhpStorm.
 * User: ologinov
 * Date: 11.08.15
 * Time: 14:06
 */
trait ComponentTrait
{
    static public function getCssPath(){
        $class_name = __CLASS__;

        // находим папку, в которой лежит класс компонента
        $reflector = new \ReflectionClass($class_name);
        $class_file_name = $reflector->getFileName();

        return dirname($class_file_name) . '/styles.less';
    }

    static public function getJsPath(){
        $class_name = __CLASS__;

        // находим папку, в которой лежит класс компонента
        $reflector = new \ReflectionClass($class_name);
        $class_file_name = $reflector->getFileName();

        return dirname($class_file_name) . '/scripts.js';
    }
}