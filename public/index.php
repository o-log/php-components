<?php

// TODO: rewrite

require_once '../vendor/autoload.php';

\PHPComponentsDemo\ComponentsDemoConfig::init();

\OLOG\Component\GenerateCSS::buildCSSAggregateFromComponents(__DIR__, __DIR__ . '/../Config');
\OLOG\Component\GenerateJS::generateJS();

\PHPComponentsDemo\DemoLayout\DemoLayoutComponent::render();