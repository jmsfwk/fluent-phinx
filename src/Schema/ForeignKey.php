<?php

namespace jmsfwk\FluentPhinx\Schema;

use Phinx\Db\Table;

class ForeignKey
{
    /** @var Table */
    private $table;
    /** @var string|string[] */
    private $columns;
    /** @var string|string[] */
    private $referencedColumns;
    /** @var string */
    private $referencedTable;
    /** @var array */
    private $options = [];

    /**
     * @param string|string[] $columns
     */
    public function __construct(Table $table, $columns)
    {
        $this->table = $table;
        $this->columns = $columns;
    }

    public function references($referencedColumns): self
    {
        $this->referencedColumns = $referencedColumns;

        return $this;
    }

    public function on(string $referencedTable): self
    {
        $this->referencedTable = $referencedTable;

        return $this;
    }

    public function onUpdate(string $action): self
    {
        $this->options['update'] = $action;

        return $this;
    }

    public function onDelete(string $action): self
    {
        $this->options['delete'] = $action;

        return $this;
    }

    public function name(string $name): self
    {
        $this->options['constraint'] = $name;

        return $this;
    }

    public function __destruct()
    {
        $this->table->addForeignKey($this->columns, $this->referencedTable, $this->referencedColumns, $this->options);
    }
}
