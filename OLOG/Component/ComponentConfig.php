<?php


namespace OLOG\Component;


class ComponentConfig
{
    static protected $generate_css = true;
    static protected $generate_js = true;
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

    /**
     * @return string
     */
    public static function getGenerateInPath(): string
    {
        return self::$generate_in_path;
    }

    /**
     * @param string $generate_in_path
     */
    public static function setGenerateInPath(string $generate_in_path)
    {
        self::$generate_in_path = $generate_in_path;
    }

    /**
     * @return string
     */
    public static function getGenerateFileName(): string
    {
        return self::$generate_file_name;
    }

    /**
     * @param string $generate_file_name
     */
    public static function setGenerateFileName(string $generate_file_name)
    {
        self::$generate_file_name = $generate_file_name;
    }

    /**
     * @return array
     */
    public static function getAddJsPluginsPathArr(): array
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