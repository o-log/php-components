<?php

namespace PHPComponentsDemo;

use PHPComponentsDemo\DemoHeader\DemoHeaderComponent;
use PHPComponentsDemo\DemoLayout\DemoLayoutComponent;

class Config
{
    //const DB_NAME_PHPMODELDEMO = 'phpmodel';

    public static function get()
    {
        $conf = [];

        $conf['component_classes_arr'] = [
            DemoLayoutComponent::class,
            DemoHeaderComponent::class
        ];

        //$conf = \Guk\CommonConfig::get();
        $conf['return_false_if_no_route'] = true; // for local php server
        /*
        $conf['cache_lifetime'] = 60;
        $conf['db'] = array(
            self::DB_NAME_PHPMODELDEMO => array(
                'host' => 'localhost',
                'db_name' => 'phpmodel',
                'user' => 'root',
                'pass' => '1'
            ),
        );
        */

        return $conf;
    }
    
    
}