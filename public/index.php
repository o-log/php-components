<?php

// TODO: rewrite

require_once '../vendor/autoload.php';

\PHPComponentsDemo\ComponentsDemoConfig::init();

\OLOG\Component\GenerateCSS::generateCSS();
\OLOG\Component\GenerateJS::generateJS();

\PHPComponentsDemo\DemoLayout\DemoLayoutComponent::render();