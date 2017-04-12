<?php

namespace PHPComponentsDemo;

use OLOG\Component\ComponentConfig;
use PHPComponentsDemo\DemoContent\DemoContentComponent;
use PHPComponentsDemo\DemoHeader\DemoHeaderComponent;
use PHPComponentsDemo\DemoLayout\DemoLayoutComponent;

class ComponentsDemoConfig
{
    public static function init()
    {
        ComponentConfig::setComponentClassesArr(
            [
                DemoLayoutComponent::class,
                DemoHeaderComponent::class,
                DemoContentComponent::class
            ]
        );

        ComponentConfig::setAddJsPluginsPathArr([
            './assets/plugin.js'
        ]);
    }
}