<?php

namespace JNeal\Provider;

use JNeal\Provider\ResponseFactory\ResponseFactory;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ErrorHandler
 * @package JNeal\Provider
 */
class ErrorHandler implements ServiceProviderInterface
{
    /**
     * @var ResponseFactory
     */
    private $responseFactory;

    /**
     * @param ResponseFactory $responseFactory
     */
    public function __construct(ResponseFactory $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

    /**
     * @param Container $app
     */
    public function register(Container $app)
    {
        $app->error(function (\Exception $e, Request $request, int $status): Response {
            $response = [
                'error' => [
                    'code' => $status,
                    'message' => $e->getMessage()
                ]
            ];

            return $this->responseFactory->make($response, $status);
        });
    }
}
