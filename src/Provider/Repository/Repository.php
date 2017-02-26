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

    /**
     * @return bool
     */
    public function add(): bool;

    /**
     * @param int $id
     * @return bool
     */
    public function update(int $id): bool;

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;
}
