<?php

// TODO: rewrite

require_once '../vendor/autoload.php';

\OLOG\ConfWrapper::assignConfig(\PHPComponentsDemo\Config::get());

\OLOG\Component\GenerateCSS::generateCss();
\OLOG\Component\GenerateJS::generateJS();
