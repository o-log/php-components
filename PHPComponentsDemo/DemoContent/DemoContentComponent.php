<?php

namespace PHPComponentsDemo\DemoContent;

use OLOG\Component\ComponentTrait;
use OLOG\Component\InterfaceComponent;

class DemoContentComponent implements InterfaceComponent
{
    use ComponentTrait;
    
    static public function render(){
        ?>

        <div class="container">
            <div>CONTENT</div>
        </div>
<?php
    }

}