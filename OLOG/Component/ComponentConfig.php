<?php


namespace OLOG\Component;


class ComponentConfig
{
    static protected $generate_css = true;
    static protected $generate_js = true;
    static protected $component_classes_arr = [];

    /**
     * @return array
     */
    public static function getComponentClassesArr()
    {
        return self::$component_classes_arr;
    }

    /**
     * @param array $component_classes_arr
     */
    public static function setComponentClassesArr($component_classes_arr)
    {
        self::$component_classes_arr = $component_classes_arr;
    }

    /**
     * @return mixed
     */
    public static function getGenerateCss()
    {
        return self::$generate_css;
    }

    /**
     * @param mixed $generate_css
     */
    public static function setGenerateCss($generate_css)
    {
        self::$generate_css = $generate_css;
    }

    /**
     * @return mixed
     */
    public static function getGenerateJs()
    {
        return self::$generate_js;
    }

    /**
     * @param mixed $generate_js
     */
    public static function setGenerateJs($generate_js)
    {
        self::$generate_js = $generate_js;
    }
}