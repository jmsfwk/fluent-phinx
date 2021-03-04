<?php

namespace jmsfwk\FluentPhinx\Schema;

use Phinx\Db\Table\Column as PhinxColumn;
use Phinx\Util\Literal;

class Column
{
    /** @var PhinxColumn */
    private $column;
    /** @var Blueprint */
    private $blueprint;

    public function __construct(PhinxColumn $column, Blueprint $blueprint)
    {
        $this->column = $column;
        $this->blueprint = $blueprint;
    }

    public function after(string $name): self
    {
        $this->column->setAfter($name);

        return $this;
    }

    public function autoIncrement(): self
    {
        $this->column->setIdentity(true);

        return $this;
    }

    public function charset(string $charset): self
    {
        $this->column->setEncoding($charset);

        return $this;
    }

    public function collation(string $collation): self
    {
        $this->column->setCollation($collation);

        return $this;
    }

    public function comment(string $comment): self
    {
        $this->column->setComment($comment);

        return $this;
    }

    public function default($value): self
    {
        $this->column->setDefault($value);

        return $this;
    }

    public function from(int $from): self
    {
        $this->column->setIncrement($from);

        return $this;
    }

    public function nullable(bool $nullable = true): self
    {
        $this->column->setNull($nullable);

        return $this;
    }

    public function unsigned(): self
    {
        $this->column->setSigned(false);

        return $this;
    }

    public function useCurrent(): self
    {
        $this->column->setDefault('CURRENT_TIMESTAMP');

        return $this;
    }

    public function virtualAs(string $expression): self
    {
        $this->column->setType(Literal::from("{$this->getColumnSqlDefinition()} AS ({$expression})"));

        return $this;
    }

    public function storedAs(string $expression): self
    {
        $this->column->setType(Literal::from("{$this->getColumnSqlDefinition()} AS ({$expression}) STORED"));

        return $this;
    }

    public function index(string $name = null): self
    {
        $this->blueprint->index($this->column->getName(), $name);

        return $this;
    }

    public function primary(): self
    {
        $this->blueprint->primary_key = $this->column->getName();

        return $this;
    }

    public function unique(string $name = null): self
    {
        $this->blueprint->unique($this->column->getName(), $name);

        return $this;
    }

    private function getColumnSqlDefinition(): string
    {
        $adapter = $this->blueprint->getTable()->getAdapter();
        $column = $this->column;

        $sqlType = $adapter->getSqlType($column->getType(), $column->getLimit());
        $def = strtoupper($sqlType['name']);

        if ($column->getPrecision() && $column->getScale()) {
            $def .= "({$column->getPrecision()}, {$column->getScale()})";
        } elseif (isset($sqlType['limit'])) {
            $def .= "({$sqlType['limit']})";
        }

        return $def;
    }
}
