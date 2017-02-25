<?php

namespace JNeal\Provider\Repository;

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
     * @var string
     */
    private $table;

    /**
     * @var string
     */
    private $primaryKey;

    /**
     * @param \PDO $db
     */
    public function __construct(\PDO $db)
    {
        $this->db = $db;
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
        $select = $this->db->prepare($this->getSelectOrderByQuery() . ($limit ? "LIMIT $limit" : ''));
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
        $select = $this->db->prepare($this->getSelectQuery() . "WHERE {$this->primaryKey} = ? LIMIT 1");
        $select->execute([$id]);

        if (!$item = $select->fetch(\PDO::FETCH_ASSOC)) {
            throw new NotFoundHttpException("Identifier '$id' not found");
        }

        return $item;
    }

    /**
     * @return string
     */
    private function getSelectQuery(): string
    {
        return "SELECT * FROM {$this->table} ";
    }

    /**
     * @return string
     */
    private function getSelectOrderByQuery(): string
    {
        return $this->getSelectQuery() . "ORDER BY {$this->primaryKey} DESC ";
    }
}
