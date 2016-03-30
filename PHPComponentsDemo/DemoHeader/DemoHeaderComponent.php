<?php

namespace PHPComponentsDemo\DemoHeader;

use OLOG\Component\ComponentTrait;
use OLOG\Component\InterfaceComponent;

class DemoHeaderComponent implements InterfaceComponent
{
    use ComponentTrait;

    static public function render()
    {
        $_component_class = \OLOG\Component\GenerateCSS::getCssClassName(__CLASS__);

        ?>
        <h1 class="<?= $_component_class ?>">PAGE HEADER</h1>
        <?php
    }
}