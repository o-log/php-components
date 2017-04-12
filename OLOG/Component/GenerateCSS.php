<?php

namespace OLOG\Component;

use OLOG\FilePath;

class GenerateCSS
{
    /**
     * передаем полный путь к папке, куда надо класть агрегаты
     * почему этот путь не кладется в конфиг: он может зависеть от точки входа, которая используется для генерации
     * при этом код например может быть примонтирован в виртуалку и запускать и изнутри, и снаружи виртуалки по совсем разным путям
     * а вызывающий файл всегда знает где он находится и может передать путь к папке агрегатов относительно себя
     *
     * @param $target_folder_path_in_filesystem
     */
    public static function buildCSSAggregateFromComponents($target_folder_path_in_filesystem, $config_folder_path_in_filesystem)
    {
        $current_version = self::getCurrentAggregatesVersion();
        $new_version = $current_version + 1;

        $components_arr = ComponentConfig::getComponentClassesArr();

        $all_components_less_str = '';
        foreach ($components_arr as $component_class_name) {
            $all_components_less_str .= self::getComponentLessStr($component_class_name);
        }

        $all_components_css_str = self::convertLessStrToCssStr($all_components_less_str, ['compress' => false]);

        $aggregate_path_in_filesystem = FilePath::constructPath([$target_folder_path_in_filesystem, self::aggregateFileName($new_version)]);

        $css_aggregate_write_result = file_put_contents($aggregate_path_in_filesystem, $all_components_css_str);
        \OLOG\Assert::assert($css_aggregate_write_result, 'CSS aggregate file write failed: ' . $aggregate_path_in_filesystem);

        $minified_aggregate_path_in_filesystem = FilePath::constructPath([$target_folder_path_in_filesystem, self::minifiedAggregateFileName($new_version)]);

        self::minifyCssFile(
            $aggregate_path_in_filesystem,
            $minified_aggregate_path_in_filesystem
        );

        self::increaseAggregateVersion($config_folder_path_in_filesystem);
    }

    static public function increaseAggregateVersion($config_folder_path_in_filesystem){
        $version = self::getCurrentAggregatesVersion();
        $version++;

        $class_name = 'AggregatesVerisonAUTOUPDATED';

        // TODO: namespace hardcoded
        $class_str = '<?php
namespace Config;
class ' . $class_name . ' {
    static public function version(){
        return ' . $version . ';
    }
}
';

        $class_file_name = $class_name . '.php';
        $class_file_path_in_filesystem = FilePath::constructPath([$config_folder_path_in_filesystem, $class_file_name]);
        $write_result = file_put_contents($class_file_path_in_filesystem, $class_str);
        \OLOG\Assert::assert($write_result, 'Aggregates version file write failed: ' . $class_file_path_in_filesystem);
    }

    public static function getCurrentAggregatesVersion(){
        $version = '1';

        // TODO: now requires Config namespace presence, remove such requirement (make namespace configurable?)
        if (class_exists('\Config\AggregatesVerisonAUTOUPDATED')){
            $version = \Config\AggregatesVerisonAUTOUPDATED::version();
        }

        return $version;
    }

    /**
     * возвращает только имя файла, без пути!
     * где этот файл лежит - должно знать приложение
     * @return string
     */
    public static function aggregateFileName($version){
        return 'aggregate_' . $version . '.css';
    }

    /**
     * возвращает только имя файла, без пути!
     * где этот файл лежит - должно знать приложение
     * @return string
     */
    public static function aggregateFileNameForCurrentVersion(){
        $version = self::getCurrentAggregatesVersion();
        return self::aggregateFileName($version);
    }

    /**
     * возвращает только имя файла, без пути!
     * где этот файл лежит - должно знать приложение
     * @return string
     */
    public static function minifiedAggregateFileName($version){
        return 'aggregate_' . $version . '.min.css';
    }

    /**
     * возвращает только имя файла, без пути!
     * где этот файл лежит - должно знать приложение
     * @return string
     */
    public static function minifiedAggregateFileNameForCurrentVersion(){
        $version = self::getCurrentAggregatesVersion();
        return self::minifiedAggregateFileName($version);
    }

    public static function getComponentLessStr($component_class_name)
    {
        \OLOG\CheckClassInterfaces::exceptionIfClassNotImplementsInterface($component_class_name, InterfaceComponent::class);

        $css_path = $component_class_name::getCssPath();
        $data = file_get_contents($css_path);

        if ($data === false) {
            throw new \Exception('Can not read file: ' . $css_path);
        }

        $data .= "\n";

        $css_class_name = self::getCssClassName($component_class_name);
        $data = str_replace('_COMPONENT_CLASS', $css_class_name, $data);

        return $data;
    }

    /**
     * Генерация Less в Css
     * @param string $input_less_str входной less
     * @param string $options опции для LESS парсера, по-умолчанию пустые
     * @return string $output_css_str выходного css
     */
    static function convertLessStrToCssStr($input_less_str, $options = '')
    {
        $less = new \Less_Parser($options);
        $less->parse($input_less_str);
        $output_css_str = $less->getCss();

        return $output_css_str;
    }

    static function minifyCssFile($css_path, $css_min_path)
    {
        $minifier = new \MatthiasMullie\Minify\CSS();

        $minifier->add($css_path);

        // TODO: error check??
        $minifier->minify($css_min_path);
    }

    /*
    static public function appendLeadingSlashIfNone($class_name)
    {
        if (!preg_match("@^\\\\@", $class_name)) { // если в начале имени класса нет слэша - добавляем
            $class_name = '\\' . $class_name;
        }

        return $class_name;
    }
    */

    public static function getCssClassName($class_name)
    {
        //$class_name = self::appendLeadingSlashIfNone($class_name); // сейчас это делается только для совместимости с предыдущей реализацийе, возможно не нужно
        $css_class_name = str_replace('\\', '_', $class_name);
        return $css_class_name;
    }
}