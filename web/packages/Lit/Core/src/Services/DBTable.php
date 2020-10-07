<?php

namespace Lit\Core\Services;

use Doctrine\DBAL\Schema\Column;
use Doctrine\DBAL\Schema\ForeignKeyConstraint;
use Doctrine\DBAL\Schema\Index;

class DBTable
{
    /**
     * @var Column[]
     */
    private $columns;
    /**
     * @var string
     */
    private $tableName;
    /**
     * @var ForeignKeyConstraint[]
     */
    private $foreignKeys;
    /**
     * @var Index[]
     */
    private $indexes;

    /**
     * DBTable constructor.
     * @param string $tableName
     * @param array $columns
     * @param array $foreignKeys
     * @param array $indexes
     */
    public function __construct(string $tableName, array $columns, array $foreignKeys, array $indexes)
    {
        $this->columns = $columns;
        $this->tableName = $tableName;
        $this->foreignKeys = $foreignKeys;
        $this->indexes = $indexes;
    }

    /**
     * @return string
     */
    public function getTableName(): string
    {
        return $this->tableName;
    }

    /**
     * @return array
     */
    public function getColumns(): array
    {
        return $this->columns;
    }

    public function getColumnsExcept() {
        return array_filter($this->columns, function($key) {
            return !in_array($key, config('core.exceptColumn'));
        }, ARRAY_FILTER_USE_KEY);
    }

    /**
     * @return array
     */
    public function getForeignKeys(): array
    {
        return $this->foreignKeys;
    }

    /**
     * @return array
     */
    public function getIndexes(): array
    {
        return $this->indexes;
    }
}
