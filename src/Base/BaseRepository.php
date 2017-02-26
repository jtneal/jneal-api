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
        $uri = 'http://'  . ($_SERVER['SERVER_NAME'] ?? '') . ($_SERVER['REQUEST_URI'] ?? '');

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

    /**
     * @return bool
     */
    public function add(): bool
    {
        return true;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function update(int $id): bool
    {
        return true;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return true;
    }
}
