<?php

namespace jmsfwk\FluentPhinx;

use Closure;
use jmsfwk\FluentPhinx\Schema\Blueprint;
use Phinx\Db\Table;

trait Fluent
{
    public function schema(string $name, Closure $callback): Table
    {
        $table = $this->table($name);

        $callback(new Blueprint($table));

        return $table;
    }

    public function create(string $name, Closure $callback): void
    {
        $table = $this->schema($name, $callback);

        $table->create();
    }

    public function update(string $name, Closure $callback): void
    {
        $table = $this->schema($name, $callback);

        $table->update();
    }
}
