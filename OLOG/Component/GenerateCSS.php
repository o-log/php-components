<?php

namespace OLOG\Component;

use OLOG\Assert;

class GenerateCSS
{
    // TODO: paths are relative to entry point??? FIX
    static $less_path = './assets/common.less';
    static $css_path = './assets/common.css';

    public static function generateCSS()
    {
        self::resetComponentsCss(); // TODO: build in memory, no intermediate file?

        $components_arr = \OLOG\ConfWrapper::value('component_classes_arr', []);
        foreach ($components_arr as $component_class_name) {
            self::registerComponentCss($component_class_name);
        }

        self::generateLessToCss(self::$less_path, self::$css_path, ['compress' => false]);
    }

    public static function resetComponentsCss(){
        $less_url = self::$less_path;
        file_put_contents($less_url, '');
    }

    public static function registerComponentCss($class_name){
        \OLOG\Model\Helper::exceptionIfClassNotImplementsInterface($class_name, InterfaceComponent::class);

        $css_path = $class_name::getCssPath();
        $data = file_get_contents($css_path);

        if ($data === false){
            throw new \Exception('Can not read file: ' . $css_path);
        }

        $css_class_name = \OLOG\Component\Helper::getCssClassName($class_name);
        $data = str_replace('_COMPONENT_CLASS', $css_class_name, $data);

        $less_path = self::$less_path;
        $res = file_put_contents($less_path, $data, FILE_APPEND);

        if ($res === false){
            throw new \Exception('Can not write file: ' . $less_path);
        }
    }

    /**
     * @param string $input_less входной less-файл
     * @param string $output_css путь выходного css
     * @param string $options опции для LESS парсера, по-умолчанию пустые
     */
    static function generateLessToCss($input_less, $output_css, $options = '')
    {
        $less = new \Less_Parser($options);
        $less->parseFile($input_less);
        $input_less = $less->getCss();
        
        Assert::assert(file_put_contents($output_css, $input_less));
    }
}