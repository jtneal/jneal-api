<?php

namespace JNeal\Provider\Repository;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class PDORepository
 * @package JNeal\Provider\Repository
 */
class PDORepository implements Repository
{
    /**
     * @var \PDO
     */
    private $db;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var string
     */
    private $table;

    /**
     * @var string
     */
    private $primaryKey;

    /**
     * @param \PDO $db
     * @param Request $request
     */
    public function __construct(\PDO $db, Request $request)
    {
        $this->db = $db;
        $this->request = $request;
    }

    /**
     * @param string $table
     * @return PDORepository
     */
    public function setTable(string $table): PDORepository
    {
        $this->table = $table;

        return $this;
    }

    /**
     * @param string $primaryKey
     * @return PDORepository
     */
    public function setPrimaryKey(string $primaryKey): PDORepository
    {
        $this->primaryKey = $primaryKey;

        return $this;
    }

    /**
     * @param int $limit
     * @return array
     */
    public function getList(int $limit = 0): array
    {
        $limit = $limit ? "LIMIT $limit" : '';
        $select = $this->db->prepare("SELECT * FROM {$this->table} ORDER BY {$this->primaryKey} DESC " . $limit);
        $select->execute();

        return $select->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @return array
     */
    public function getRecent(): array
    {
        return $this->getList(6);
    }

    /**
     * @param int $id
     * @return array
     * @throws NotFoundHttpException
     */
    public function getItem(int $id): array
    {
        $select = $this->db->prepare("SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ? LIMIT 1");
        $select->execute([$id]);

        if (!$item = $select->fetch(\PDO::FETCH_ASSOC)) {
            throw new NotFoundHttpException("Identifier '$id' not found");
        }

        return $item;
    }

    /**
     * @return bool
     */
    public function add(): bool
    {
        $data = $this->getFilteredData();
        $keys = implode(',', array_keys($data));
        $prepared = implode(',', array_fill(0, count($data), '?'));

        $insert = $this->db->prepare("INSERT INTO {$this->table} ($keys) VALUES ($prepared)");
        $insert->execute(array_values($data));

        return true;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function update(int $id): bool
    {
        $data = $this->getFilteredData();
        $prepare = implode(' = ?, ', array_keys($data));

        $update = $this->db->prepare("UPDATE {$this->table} SET $prepare = ? WHERE {$this->primaryKey} = ?");
        $update->execute(array_merge(array_values($data), [$id]));

        return true;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $delete = $this->db->prepare("DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?");
        $delete->execute([$id]);

        return true;
    }

    /**
     * @return array
     */
    private function getValidColumns(): array
    {
        $select = $this->db->prepare("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = ?");
        $select->execute([$this->table]);

        return $select->fetchAll(\PDO::FETCH_COLUMN, 0);
    }

    /**
     * @return array
     */
    private function getFilteredData(): array
    {
        return array_intersect_key($this->request->request->all(), array_flip($this->getValidColumns()));
    }
}
