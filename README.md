# Fluent Phinx

Laravel-style migrations for [Phinx][phinx].

- [Introduction](#introduction)
- [Migration Structure](#migration-structure)
- [Tables](#tables)
    - [Creating Tables](#creating-tables)
    - [Table Options](#table-options)

<a name="introduction"></a>
## Introduction

Phinx provides a way to declare schemas in migrations, but it's somewhat difficult
to use because of the array of options that vary by column type.

*Fluent Phinx* provides a fluent Laravel-style schema builder to simplify writing
and reading migrations.

<a name="migration-structure"></a>
## Migration Structure

*Fluent Phinx* relies on regular Phinx [migration files][creating-a-new-migration],
with either a `change` method or `up`/`down` method pair.

The `Fluent` trait can be used to add fluent functionality to the migration file.

```php
<?php

use jmsfwk\FluentPhinx\Fluent;
use jmsfwk\FluentPhinx\Schema\Blueprint;
use Phinx\Migration\AbstractMigration;

class CreateUsersTable extends AbstractMigration
{
    use Fluent;

    public function change()
    {
        $this->create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            
            $table->id = false; // Turn off automatic id column
            $table->primary_key = 'id'; // Set the 'id' column as the primary key
        });
    }
}
```

<a name="tables"></a>
## Tables

<a name="creating-tables"></a>
### Creating Tables

To create a new database table, use the `create` method on from the `Fluent` trait. The create method accepts two arguments: the first is the name of the table, while the second is a Closure which receives a Blueprint object that may be used to define the new table:

    $this->create('users', function (Blueprint $table) {
        $table->increments('id');
    });

When creating the table, you may use any of the schema builder's column methods to define the table's columns.

<a name="table-options"></a>
### Table Options

You may use the following properties on the schema builder to define the table's options:

Command  |  Description
-------  |  -----------
`$table->engine = 'InnoDB';`  |  Specify the table storage engine (MySQL).
`$table->collation = 'utf8mb4_unicode_ci';`  |  Specify a default collation for the table (MySQL).
`$table->comment = 'Explain something';`  |  Specify a comment for the table.
`$table->id = 'id'`  |  The name of the automatically created id field (set to `false` to disable).
`$table->primary_key = 'id'`  |  The column to use as the primary key (can be set to an array of columns).
`$table->signed = false`  |  Whether the primary key is signed (defaults to `true`).

[phinx]: https://book.cakephp.org/phinx/0/en/index.html
[creating-a-new-migration]: https://book.cakephp.org/phinx/0/en/migrations.html#creating-a-new-migration
