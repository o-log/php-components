<?php

namespace PHPComponentsDemo;

use PHPComponentsDemo\DemoContent\DemoContentComponent;
use PHPComponentsDemo\DemoHeader\DemoHeaderComponent;
use PHPComponentsDemo\DemoLayout\DemoLayoutComponent;

class ComponentsDemoConfig
{
    public static function get()
    {
        $conf = [];

        $conf['component_classes_arr'] = [
            DemoLayoutComponent::class,
            DemoHeaderComponent::class,
            DemoContentComponent::class
        ];

        $conf['return_false_if_no_route'] = true; // for local php server
        
        $conf[\OLOG\Component\ComponentConstants::MODULE_NAME] = new \OLOG\Component\ComponentConfig(true, true);
        
        return $conf;
    }
}