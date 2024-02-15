<?php

use Ps\Business\AppBusinessFactory;

require_once __DIR__ . '/vendor/autoload.php';

$appBusinessFactory = new AppBusinessFactory();
$fileName = $appBusinessFactory
    ->createInput()
    ->getArgument($argv, 1);

$appBusinessFactory
    ->createApplication()
    ->calculateCommissionsFromFile($fileName);
