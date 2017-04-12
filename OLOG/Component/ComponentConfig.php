<?php

namespace OLOG\Component;

class ComponentConfig
{
    static protected $component_classes_arr = [];
    static protected $generate_in_path = './assets/';
    static protected $generate_file_name = 'common';
    static protected $add_js_plugins_path_arr = [];

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
     * @return string
     */
    public static function getGenerateInPath()
    {
        return self::$generate_in_path;
    }

    /**
     * @param string $generate_in_path
     */
    public static function setGenerateInPath($generate_in_path)
    {
        self::$generate_in_path = $generate_in_path;
    }

    /**
     * @return string
     */
    public static function getGenerateFileName()
    {
        return self::$generate_file_name;
    }

    /**
     * @param string $generate_file_name
     */
    public static function setGenerateFileName($generate_file_name)
    {
        self::$generate_file_name = $generate_file_name;
    }

    /**
     * @return array
     */
    public static function getAddJsPluginsPathArr()
    {
        return self::$add_js_plugins_path_arr;
    }

    /**
     * @param array $add_js_plugins_path_arr
     */
    public static function setAddJsPluginsPathArr(array $add_js_plugins_path_arr)
    {
        self::$add_js_plugins_path_arr = $add_js_plugins_path_arr;
    }
}