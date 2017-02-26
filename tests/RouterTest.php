<?php

namespace JNeal;

use PHPUnit\Framework\TestCase;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class RouterTest
 * @package JNeal
 */
class RouterTest extends TestCase
{
    /**
     * Test Connect
     */
    public function testConnect()
    {
        $app = new Application();
        $router = new Router();

        $app['auth.token'] = 'test';
        $app['request'] = Request::createFromGlobals();
        $app['auth'] = new Auth($app['request'], $app['auth.token']);

        $controllerCollection = $router->connect($app);

        $this->assertInstanceOf('Silex\ControllerCollection', $controllerCollection);
    }
}
