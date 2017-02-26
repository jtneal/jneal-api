<?php

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Silex\Application();

$app['request'] = Symfony\Component\HttpFoundation\Request::createFromGlobals();
$app['env'] = getenv('JNEAL_API_ENV') ?? 'prod';
$app['db.dsn'] = getenv('JNEAL_DB_DSN') ?? '';
$app['db.user'] = getenv('JNEAL_DB_USER') ?? '';
$app['db.pass'] = getenv('JNEAL_DB_PASS') ?? '';

require __DIR__ . '/../config/' . $app['env'] . '.php';

if ($app['debug']) {
    ini_set('display_errors', 1);
    ini_set('error_reporting', E_ALL);
}

$app->register(new Silex\Provider\ServiceControllerServiceProvider());
$app->register(new JNeal\IOCEntries());
$app->register(new JNeal\Provider\ErrorHandler($app['responseFactory.json']));

$app->mount('/api', new JNeal\Router());

$app->run($app['request']);
