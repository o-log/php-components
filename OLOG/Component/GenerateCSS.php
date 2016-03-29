<?php

namespace OLOG\Component;

use OLOG\Assert;

class GenerateCSS
{
    // TODO: relative paths??? FIX
    static $less_path = './assets/common.less';
    static $css_path = './assets/common.css';

    public static function generateCss()
    {
        self::resetComponentsCss();

        $components_arr = \OLOG\ConfWrapper::value('component_classes_arr', []);
        foreach ($components_arr as $component_class_name) {
            self::registerComponentCss($component_class_name);
        }

        /*
        $main1_less_url = './sites/all/libraries/design/_spbver_/sportbox2015/css/main1.less';
        $main1_output_path = './sites/all/libraries/design/_spbver_/sportbox2015/css/main1.css';

        $main2_less_url = './sites/all/libraries/design/_spbver_/sportbox2015/css/main2.less';
        $main2_output_path = './sites/all/libraries/design/_spbver_/sportbox2015/css/main2.css';
        */

        self::generateLessToCss(self::$less_path, self::$css_path, ['compress' => false]);
    }

    public static function resetComponentsCss(){
        $less_url = self::$less_path;
        file_put_contents($less_url, '');
    }

    public static function registerComponentCss($class_name){
        //\Sportbox\Helpers::assert($class_name instanceof \Sportbox\Component\InterfaceComponent, $class_name . ' must implement');

        $css_class_name = \OLOG\Component\Helper::getCssClassName($class_name);

        // TODO: check component interface
        
        $css_path = $class_name::getCssPath();
        $data = file_get_contents($css_path);
        //Assert::assert($data);

        if ($data === false){
            throw new \Exception('Can not read file: ' . $css_path);
        }

        $data = str_replace('_COMPONENT_CLASS', $css_class_name, $data);

        $less_path = self::$less_path;
        $res = file_put_contents($less_path, $data, FILE_APPEND);
        //Assert::assert($res);

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