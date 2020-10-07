<?php

namespace Lit\Core\Services;

use Doctrine\DBAL\Schema\AbstractSchemaManager;

class DatabaseService
{
    /**
     * @var AbstractSchemaManager $manager
     */
    private $manager;
    private $exceptTables = ['failed_jobs', 'migrations', 'password_resets'];

    /**
     * DatabaseService constructor.
     */
    public function __construct()
    {
        $this->manager = app()->make('databaseManager');
    }

    /**
     * @return DBTable[]
     */
    public function tables() {
        return array_map(function($tableName) {
            return new DBTable(
                $tableName,
                $this->manager->listTableColumns($tableName),
                $this->_foreignKey($tableName),
                $this->manager->listTableIndexes($tableName)
            );
        }, $this->_tables());
    }

    private function _foreignKey($tableName) {
        if($this->manager->getDatabasePlatform()->supportsForeignKeyConstraints()) {
            return $this->manager->listTableForeignKeys($tableName);
        }

        return [];
    }

    private function _tables() {
        return array_diff($this->manager->listTableNames(), $this->exceptTables);
    }

    public function getTableWithColumns($tableName) {
        if(!$this->manager->tablesExist($tableName)) {
            return abort(404);
        }

        return new DBTable(
            $tableName,
            $this->manager->listTableColumns($tableName),
            $this->_foreignKey($tableName),
            $this->manager->listTableIndexes($tableName)
        );
    }
}
