<?php

namespace OLOG\Component;

trait ComponentTrait
{
    // TODO: return array to allow multiple files? Separate method for array?
    static public function getCssPath(){
        $class_name = __CLASS__;

        // находим папку, в которой лежит класс компонента
        $reflector = new \ReflectionClass($class_name);
        $class_file_name = $reflector->getFileName();

        return dirname($class_file_name) . '/styles.less';
    }

    // TODO: return array to allow multiple files? Separate method for array?
    static public function getJsPath(){
        $class_name = __CLASS__;

        // находим папку, в которой лежит класс компонента
        $reflector = new \ReflectionClass($class_name);
        $class_file_name = $reflector->getFileName();

        return dirname($class_file_name) . '/scripts.js';
    }
}