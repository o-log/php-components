<?php

namespace OLOG\Component;

use OLOG\Assert;
use OLOG\FilePath;

class GenerateJS
{
    static public function generateComponentInstanceId()
    {
        $id = uniqid('comp_');
        return $id;
    }

    public static function buildJSAggregateFromComponents($target_folder_path_in_filesystem, $config_folder_path_in_filesystem)
    {
        $current_version = AggregateVersions::getCurrentAggregatesVersion();
        $new_version = $current_version + 1;

        $components_js_file_paths_arr = array();
        $components_arr = ComponentConfig::getComponentClassesArr();
        foreach ($components_arr as $component_class_name) {
            array_push($components_js_file_paths_arr, self::getComponentJSPathInFilesystem($component_class_name));
        }

        $js_plugins_path_arr = ComponentConfig::getAddJsPluginsPathArr();
        $source_js_file_paths_arr = array_merge($js_plugins_path_arr, $components_js_file_paths_arr);

        $aggregate_path_in_filesystem = FilePath::constructPath([$target_folder_path_in_filesystem, self::aggregateFileName($new_version)]);
        $minified_aggregate_path_in_filesystem = FilePath::constructPath([$target_folder_path_in_filesystem, self::minifiedAggregateFileName($new_version)]);

        self::buildAndSaveAggregate($source_js_file_paths_arr, $aggregate_path_in_filesystem);

        self::minifyJs($aggregate_path_in_filesystem, $minified_aggregate_path_in_filesystem);

        AggregateVersions::increaseAggregateVersion($config_folder_path_in_filesystem);
    }

    static protected function aggregateFileName($version){
        return 'aggregate_' . $version . '.js';
    }

    static protected function minifiedAggregateFileName($version){
        return 'aggregate_' . $version . '.min.js';
    }

    static public function aggregateFileNameForCurrentVersion(){
        $version = AggregateVersions::getCurrentAggregatesVersion();
        return self::aggregateFileName($version);
    }

    static public function minifiedAggregateFileNameForCurrentVersion(){
        $version = AggregateVersions::getCurrentAggregatesVersion();
        return self::minifiedAggregateFileName($version);
    }

    protected static function getComponentJSPathInFilesystem($component_class_name)
    {
        // TODO: check interface

        $js_path = $component_class_name::getJsPath();

        return $js_path;
    }

    /**
     * сборщик агрегата javascript
     * @param $source_file_paths_arr - массив склеиваемых скриптов
     * @param $js_aggregate_path_in_filesystem - путь к агрегату
     */
    protected static function buildAndSaveAggregate($source_file_paths_arr, $js_aggregate_path_in_filesystem)
    {
        $contents = '';

        foreach ($source_file_paths_arr as $javascript) {
            $file_path = $javascript;

            // TODO: not used now: review, add support for external files???
            /*
            if (!preg_match('@(^\/|^[a-z]:[\/\\\\])@i', $javascript)) {
                // путь к скрипту не начинается с / или x:\
                $js_base_path = __DIR__ . '/../..'; // ?
                $file_path = $js_base_path . '/' . $javascript;
            }
            */

            $contents .= file_get_contents($file_path);

            if ($contents === false) {
                throw new \Exception('Can not read file: ' . $file_path);
            }

            $contents .= "\n";
        }

        Assert::assert(file_put_contents($js_aggregate_path_in_filesystem, $contents), 'JS aggregate save failed');
    }

    protected static function minifyJs($js_aggregate_path_in_filesystem, $minified_aggregate_path_in_filesystem)
    {
        $minifier = new \MatthiasMullie\Minify\JS();

        // TODO: errors check?
        $minifier->add($js_aggregate_path_in_filesystem);

        // TODO: errors check??
        $minifier->minify($minified_aggregate_path_in_filesystem);
    }
}