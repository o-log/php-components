<?php

namespace OLOG\Component;

class Helper{
    static public function generateComponentInstanceId(){
        $id = uniqid('comp_');
        return $id;
    }

    public static function getCssClassName($class_name){
        $class_name = \OLOG\Model\Helper::globalizeClassName($class_name);
        $css_class_name = str_replace('\\', '_', $class_name);
        return $css_class_name;
    }

}