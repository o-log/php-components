<?php

namespace OLOG\Component;

use OLOG\FilePath;

class AggregateVersions
{

    public static function increaseAggregateVersion($config_folder_path_in_filesystem)
    {
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

    public static function getCurrentAggregatesVersion()
    {
        $version = '1';

        // TODO: now requires Config namespace presence, remove such requirement (make namespace configurable?)
        if (class_exists('\Config\AggregatesVerisonAUTOUPDATED')) {
            $version = \Config\AggregatesVerisonAUTOUPDATED::version();
        }

        return $version;
    }
}