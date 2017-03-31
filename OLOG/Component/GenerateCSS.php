<?php

namespace OLOG\Component;

class GenerateCSS
{
    static public function appendLeadingSlashIfNone($class_name)
    {
        if (!preg_match("@^\\\\@", $class_name)) { // если в начале имени класса нет слэша - добавляем
            $class_name = '\\' . $class_name;
        }

        return $class_name;
    }

    public static function getCssClassName($class_name)
    {
        $class_name = self::appendLeadingSlashIfNone($class_name); // сейчас это делается только для совместимости с предыдущей реализацийе, возможно не нужно
        $css_class_name = str_replace('\\', '_', $class_name);
        return $css_class_name;
    }

    public static function generateCSS()
    {
        if (!ComponentConfig::getGenerateCss()) {
            return;
        }

        $components_arr = ComponentConfig::getComponentClassesArr();

        $components_less_str = '';
        foreach ($components_arr as $component_class_name) {
            $components_less_str .= self::getLessStrInRegisterComponentCss($component_class_name);
        }

        $output_css_str = self::getGenerateLessToCssStr($components_less_str, ['compress' => false]);

        $css_path = ComponentConfig::getGenerateInPath() . ComponentConfig::getGenerateFileName() . '.css';

        \OLOG\Assert::assert(file_put_contents($css_path, $output_css_str));

        self::minifyCss();
    }

    public static function getLessStrInRegisterComponentCss($class_name)
    {
        \OLOG\CheckClassInterfaces::exceptionIfClassNotImplementsInterface($class_name, InterfaceComponent::class);

        $css_path = $class_name::getCssPath();
        $data = file_get_contents($css_path);

        if ($data === false) {
            throw new \Exception('Can not read file: ' . $css_path);
        }

        $data .= "\n";

        $css_class_name = self::getCssClassName($class_name);
        $data = str_replace('_COMPONENT_CLASS', $css_class_name, $data);

        return $data;
    }

    /**
     * Генерация Less в Css
     * @param string $input_less_str входной less
     * @param string $options опции для LESS парсера, по-умолчанию пустые
     * @return string $output_css_str выходного css
     */
    static function getGenerateLessToCssStr($input_less_str, $options = '')
    {
        $less = new \Less_Parser($options);
        $less->parse($input_less_str);
        $output_css_str = $less->getCss();

        return $output_css_str;
    }

    static function minifyCss()
    {
        $minifier = new \MatthiasMullie\Minify\CSS();
        $css_path = ComponentConfig::getGenerateInPath() . ComponentConfig::getGenerateFileName() . '.css';
        $css_min_path = ComponentConfig::getGenerateInPath() . ComponentConfig::getGenerateFileName() . '.min.css';

        $minifier->add($css_path);
        $minifier->minify($css_min_path);
    }

    static public function getCssMinFileName()
    {
        return ComponentConfig::getGenerateFileName() . '.min.css';
    }
}