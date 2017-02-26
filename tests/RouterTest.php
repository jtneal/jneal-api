<?php

namespace JNeal;

use PHPUnit\Framework\TestCase;
use Silex\Application;

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

        $controllerCollection = $router->connect($app);

        $this->assertInstanceOf('Silex\ControllerCollection', $controllerCollection);
    }
}
