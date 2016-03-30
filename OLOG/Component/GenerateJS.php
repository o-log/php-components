<?php

namespace OLOG\Component;

class GenerateJS
{
    public static function generateJS()
    {
        $components_js_arr = array();

        $components_arr = \OLOG\ConfWrapper::value('component_classes_arr', []);
        foreach ($components_arr as $component_class_name) {
            self::registerComponentJs($component_class_name, $components_js_arr);
        }

        $js_arr = array(
        );

        $source_js_arr = array_merge($js_arr, $components_js_arr);

        self::processJsArr(
            $source_js_arr,
            './assets/common.js'
        );
    }

    public static function registerComponentJs($class_name, &$js_arr){
        //\Sportbox\Helpers::assert($class_name instanceof \Sportbox\Component\InterfaceComponent, $class_name . ' must implement');

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
        $js_base_path = __DIR__ . '/../..'; // ?
        $contents = '';

        foreach ($javascripts_arr as $javascript) {
            $file_path = $javascript;

            // путь к скрипту не начинается с / или x:\
            if (!preg_match('@(^\/|^[a-z]:[\/\\\\])@i', $javascript)){
                $file_path = $js_base_path . '/' . $javascript;
            }

            $contents .= file_get_contents($file_path);
            $contents .= "\n";
        }

        //$output_path = $js_base_path . '/' . $output_path;
        file_put_contents($output_path, $contents);
    }
}