<?php

namespace JNeal\Provider\Repository;

/**
 * Interface Repository
 * @package JNeal\Provider\Repository
 */
interface Repository
{
    /**
     * @return array
     */
    public function getList(): array;

    /**
     * @param int $id
     * @return array
     */
    public function getItem(int $id): array;
}
