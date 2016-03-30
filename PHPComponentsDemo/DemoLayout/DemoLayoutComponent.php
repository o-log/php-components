<?php

namespace PHPComponentsDemo\DemoLayout;

use OLOG\Component\ComponentTrait;
use OLOG\Component\InterfaceComponent;
use PHPComponentsDemo\DemoContent\DemoContentComponent;
use PHPComponentsDemo\DemoHeader\DemoHeaderComponent;

class DemoLayoutComponent implements InterfaceComponent
{
    use ComponentTrait;

    static public function render(){
        $_component_class = \OLOG\Component\GenerateCSS::getCssClassName(__CLASS__);

        ?>
        <html>
        <head>
            <link href="/assets/common.css" rel="stylesheet"/>
        </head>

        <body>
        <div class="<?= $_component_class ?>">

        <?php DemoHeaderComponent::render() ?>
        <?php DemoContentComponent::render() ?>
            </div>
        </body>

        </html>
        <?php
    }
}