<?php

use Ps\Business\AppBusinessFactory;

define('PROJECT_DIR', __DIR__ . '/src');
require_once __DIR__ . '/vendor/autoload.php';

$appBusinessFactory = new AppBusinessFactory();
$fileName = $appBusinessFactory
    ->createInput()
    ->getArgument($argv, 1);

$appBusinessFactory
    ->createApplication()
    ->calculateCommissionsFromFile($fileName);
