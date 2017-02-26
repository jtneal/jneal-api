<?php

namespace JNeal\Base;

use JNeal\Provider\Repository\Repository;

/**
 * Class BaseRepository
 * @package JNeal\Base
 */
class BaseRepository implements Repository
{
    /**
     * @return array
     */
    public function getList(): array
    {
        $uri = 'http://'  . ($_SERVER['SERVER_NAME'] ?? 'jneal.com') . $_SERVER['REQUEST_URI'];

        return [
            'links' => [
                [
                    'href' => $uri,
                    'rel' => 'self',
                    'method' => 'GET'
                ],
                [
                    'href' => $uri . 'portfolio',
                    'rel' => 'portfolio',
                    'method' => 'GET'
                ]
            ]
        ];
    }

    /**
     * @param int $id
     * @return array
     */
    public function getItem(int $id): array
    {
        return [];
    }
}
