<?php

use Silex\Provider\MonologServiceProvider;

$app['debug'] = true;

$app->register(new MonologServiceProvider(), ['monolog.logfile' => __DIR__ . '/../logs/dev.log']);
