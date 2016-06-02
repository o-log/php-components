<?php

// TODO: rewrite

require_once '../vendor/autoload.php';

\OLOG\ConfWrapper::assignConfig(\PHPComponentsDemo\ComponentsDemoConfig::get());

\OLOG\Component\GenerateCSS::generateCSS();
\OLOG\Component\GenerateJS::generateJS();

\PHPComponentsDemo\DemoLayout\DemoLayoutComponent::render();