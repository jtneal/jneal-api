<?php

namespace JNeal\Provider\ResponseFactory;

use Symfony\Component\HttpFoundation\Response;

/**
 * Interface ResponseFactory
 * @package JNeal\Provider\ResponseFactory
 */
interface ResponseFactory
{
    /**
     * @param array $response
     * @param int $status
     * @return Response
     */
    public function make(array $response, int $status = 200): Response;
}
