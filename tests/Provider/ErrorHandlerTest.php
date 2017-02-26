<?php

namespace JNeal\Provider;

use JNeal\Provider\ResponseFactory\JsonResponseFactory;
use PHPUnit\Framework\TestCase;
use Silex\Application;

/**
 * Class ErrorHandlerTest
 * @package JNeal\Provider
 */
class ErrorHandlerTest extends TestCase
{
    /**
     * Test Error Handler
     */
    public function testErrorHandler()
    {
        $app = new Application();
        $errorHandler = new ErrorHandler(new JsonResponseFactory());

        $errorHandler->register($app);

        ob_start();
        $app->run();
        $response = json_decode(ob_get_clean());

        $this->assertEquals(404, $response->error->code);
        $this->assertEquals('No route found for "GET /"', $response->error->message);
    }
}
