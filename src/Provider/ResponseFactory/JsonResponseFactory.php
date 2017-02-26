<?php

namespace JNeal\Provider\ResponseFactory;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class JsonResponseFactory
 * @package JNeal\Provider\ResponseFactory
 */
class JsonResponseFactory implements ResponseFactory
{
    /**
     * @param array $response
     * @param int $status
     * @return Response
     */
    public function make(array $response, int $status = 200): Response
    {
        return new JsonResponse($response, $status);
    }
}
