<?php

namespace JNeal\Middleware;

use PHPUnit\Framework\TestCase;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class JsonRequestParserTest
 * @package JNeal\Middleware
 */
class JsonRequestParserTest extends TestCase
{
    /**
     * Test Json Request Parser
     */
    public function testJsonRequestParser()
    {
        $request = Request::create(
            '/test',
            'POST',
            [],
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{"key1":"value1","key2":"value2"}'
        );

        $app = new Application();
        $app['request'] = $request;
        $app->register(new JsonRequestParser());
        $app->post('/test', function () { return 'test'; });
        $result = $app->handle($app['request']);

        $this->assertEquals('value1', $app['request']->request->get('key1'));
        $this->assertEquals('value2', $app['request']->request->get('key2'));
        $this->assertEquals('test', $result->getContent());
    }
}
