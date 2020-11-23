<?php

namespace jmsfwk\FluentPhinx\Schema;

use Phinx\Db\Table\Column as PhinxColumn;

class Column
{
    /** @var PhinxColumn */
    private $column;

    public function __construct(PhinxColumn $column)
    {
        $this->column = $column;
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

    public function default($comment): self
    {
        $this->column->setDefault($comment);

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
}
