<?php

namespace JNeal\Middleware;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class JsonRequestParser
 * @package JNeal\Middleware
 */
class JsonRequestParser implements ServiceProviderInterface
{
    /**
     * @param Container $app
     */
    public function register(Container $app)
    {
        $app->before(function (Request $request) {
            if ($request->headers->get('Content-Type') === 'application/json') {
                $request->request->replace((array) json_decode($request->getContent(), true));
            }
        });
    }
}
