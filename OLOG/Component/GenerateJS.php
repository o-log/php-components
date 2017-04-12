<?php

namespace OLOG\Component;

class GenerateJS
{
    static public function generateComponentInstanceId()
    {
        $id = uniqid('comp_');
        return $id;
    }

    public static function generateJS()
    {
        $components_js_arr = array();

        $components_arr = ComponentConfig::getComponentClassesArr();
        foreach ($components_arr as $component_class_name) {
            self::registerComponentJs($component_class_name, $components_js_arr);
        }

        $js_arr = array();

        $source_js_arr = array_merge($js_arr, $components_js_arr);

        $js_path = ComponentConfig::getGenerateInPath() . ComponentConfig::getGenerateFileName() . '.js';

        self::processJsArr($source_js_arr, $js_path);

        self::minifyJs();
    }

    public static function registerComponentJs($class_name, &$js_arr)
    {
        // TODO: check interface

        $js_path = $class_name::getJsPath();

        array_push($js_arr, $js_path);
        return $js_arr;
    }

    /**
     * сборщик агрегата javascript
     * @param $javascripts_arr - массив склеиваемых скриптов
     * @param $output_path - путь к агрегату
     */
    public static function processJsArr($javascripts_arr, $output_path)
    {
        $contents = '';

        foreach ($javascripts_arr as $javascript) {
            $file_path = $javascript;

            // TODO: not used now: review, add support for external files???
            if (!preg_match('@(^\/|^[a-z]:[\/\\\\])@i', $javascript)) {
                // путь к скрипту не начинается с / или x:\
                $js_base_path = __DIR__ . '/../..'; // ?
                $file_path = $js_base_path . '/' . $javascript;
            }

            $contents .= file_get_contents($file_path);

            if ($contents === false) {
                throw new \Exception('Can not read file: ' . $file_path);
            }

            $contents .= "\n";
        }

        file_put_contents($output_path, $contents);
    }

    static function minifyJs()
    {
        $minifier = new \MatthiasMullie\Minify\JS();
        $js_path = ComponentConfig::getGenerateInPath() . ComponentConfig::getGenerateFileName() . '.js';
        $js_min_path = ComponentConfig::getGenerateInPath() . ComponentConfig::getGenerateFileName() . '.min.js';

        $js_plugins_path_arr = ComponentConfig::getAddJsPluginsPathArr();
        foreach ($js_plugins_path_arr as $js_plugins_path) {
            $minifier->add($js_plugins_path);
        }

        $minifier->add($js_path);
        $minifier->minify($js_min_path);
    }

    static public function getJsMinFileName()
    {
        return ComponentConfig::getGenerateFileName() . '.min.js';
    }
}