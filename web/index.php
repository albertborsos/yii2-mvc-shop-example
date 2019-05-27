<?php

require __DIR__ . '/../vendor/autoload.php';
$config = \codemix\yii2confload\Config::bootstrap(__DIR__ . '/..');

Yii::createObject(\yii\web\Application::class, [$config->web()])->run();
