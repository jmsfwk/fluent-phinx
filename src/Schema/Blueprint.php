<?php

namespace jmsfwk\FluentPhinx\Schema;

use Phinx\Db\Adapter\AdapterInterface;
use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Db\Table;
use Phinx\Db\Table\Column as PhinxColumn;

/**
 * @property-write string|false $id The name of the automatically created identity field, or `false` to not generate the id
 * @property-write string|string[] $primary_key
 * @property-write string|null $comment
 * @property-write string|null $row_format
 * @property-write string|null $engine
 * @property-write string|null $collation
 * @property-write string|null $signed
 */
class Blueprint
{
    /** @var Table */
    private $table;

    public function __construct(Table $table)
    {
        $this->table = $table;
    }

    /* Columns */

    public function bigIncrements(string $name): Column
    {
        return $this->addIncrements($name, MysqlAdapter::INT_BIG);
    }

    public function bigInteger(string $name): Column
    {
        return $this->addInteger($name, MysqlAdapter::INT_BIG);
    }

    public function binary(string $name): Column
    {
        return $this->addColumn($name, AdapterInterface::PHINX_TYPE_BINARY);
    }

    public function boolean(string $name): Column
    {
        return $this->addColumn($name, AdapterInterface::PHINX_TYPE_BOOLEAN);
    }

    public function char(string $name, ?int $limit): Column
    {
        return $this->addColumn($name, AdapterInterface::PHINX_TYPE_CHAR, compact('limit'));
    }

    public function date(string $name): Column
    {
        return $this->addColumn($name, AdapterInterface::PHINX_TYPE_DATE);
    }

    public function dateTime(string $name, int $precision = 0): Column
    {
        return $this->addColumn($name, AdapterInterface::PHINX_TYPE_DATETIME, ['limit' => $precision]);
    }

    public function dateTimeTz(string $name, int $precision = 0): Column
    {
        return $this->addColumn($name, AdapterInterface::PHINX_TYPE_DATETIME, ['limit' => $precision, 'timezone' => true]);
    }

    public function decimal(string $name, int $total = 8, int $places = 2): Column
    {
        return $this->addColumn($name, AdapterInterface::PHINX_TYPE_DECIMAL, ['precision' => $total, 'scale' => $places]);
    }

    public function double(string $name, int $total = 8, int $places = 2): Column
    {
        return $this->addColumn($name, AdapterInterface::PHINX_TYPE_DOUBLE, ['precision' => $total, 'scale' => $places]);
    }

    public function enum(string $name, array $values): Column
    {
        return $this->addColumn($name, AdapterInterface::PHINX_TYPE_ENUM, compact('values'));
    }

    public function float(string $name, int $total = 8, int $places = 2): Column
    {
        return $this->addColumn($name, AdapterInterface::PHINX_TYPE_FLOAT, ['precision' => $total, 'scale' => $places]);
    }

    public function geometry(string $name): Column
    {
        return $this->addColumn($name, AdapterInterface::PHINX_TYPE_GEOMETRY);
    }

    public function increments(string $name): Column
    {
        return $this->addIncrements($name);
    }

    public function integer(string $name): Column
    {
        return $this->addInteger($name);
    }

    public function json(string $name): Column
    {
        return $this->addColumn($name, AdapterInterface::PHINX_TYPE_JSON);
    }

    public function jsonb(string $name): Column
    {
        return $this->addColumn($name, AdapterInterface::PHINX_TYPE_JSONB);
    }

    public function lineString(string $name): Column
    {
        return $this->addColumn($name, AdapterInterface::PHINX_TYPE_LINESTRING);
    }

    public function longText(string $name): Column
    {
        return $this->addText($name, MysqlAdapter::TEXT_LONG);
    }

    public function macAddress(string $name): Column
    {
        return $this->addColumn($name, AdapterInterface::PHINX_TYPE_MACADDR);
    }

    public function mediumIncrements(string $name): Column
    {
        return $this->addIncrements($name, MysqlAdapter::INT_MEDIUM);
    }

    public function mediumInteger(string $name): Column
    {
        return $this->addInteger($name, MysqlAdapter::INT_MEDIUM);
    }

    public function mediumText(string $name): Column
    {
        return $this->addText($name, MysqlAdapter::TEXT_MEDIUM);
    }

    public function point(string $name): Column
    {
        return $this->addColumn($name, AdapterInterface::PHINX_TYPE_POINT);
    }

    public function polygon(string $name): Column
    {
        return $this->addColumn($name, AdapterInterface::PHINX_TYPE_POLYGON);
    }

    public function set(string $name, array $values): Column
    {
        return $this->addColumn($name, AdapterInterface::PHINX_TYPE_SET, compact('values'));
    }

    public function smallIncrements(string $name): Column
    {
        return $this->addIncrements($name, MysqlAdapter::INT_SMALL);
    }

    public function smallInteger(string $name): Column
    {
        return $this->addInteger($name, MysqlAdapter::INT_SMALL);
    }

    public function string(string $name, int $limit = null): Column
    {
        return $this->addColumn($name, AdapterInterface::PHINX_TYPE_STRING, compact('limit'));
    }

    public function text(string $name): Column
    {
        return $this->addText($name);
    }

    public function time(string $name): Column
    {
        return $this->addColumn($name, AdapterInterface::PHINX_TYPE_TIME);
    }

    public function tinyInteger(string $name): Column
    {
        return $this->addInteger($name, MysqlAdapter::INT_TINY);
    }

    /* Indexes */

    /**
     * @param string|string[] $columns
     */
    public function index($columns, string $name = null): void
    {
        $this->table->addIndex($columns, compact('name'));
    }

    /**
     * @param string|string[] $columns
     */
    public function foreign($columns, string $name = null): ForeignKey
    {
        $key = new ForeignKey($this->table, $columns);
        if ($name) {
            $key->name($name);
        }

        return $key;
    }

    /**
     * @param string|string[] $columns
     */
    public function unique($columns, string $name = null): void
    {
        $this->table->addIndex($columns, compact('name') + ['unique' => true]);
    }

    /**
     * @param string|string[] $columns
     */
    public function dropIndex($columns): void
    {
        if (is_array($columns)) {
            $this->table->removeIndex($columns);
            return;
        }

        $this->table->removeIndexByName($columns);
    }

    /**
     * @param string|string[] $columns
     */
    public function dropUnique($columns): void
    {
        $this->dropIndex($columns);
    }

    public function addColumn(string $name, string $type, array $options = []): Column
    {
        $column = new PhinxColumn();
        $column->setName($name)
            ->setType($type)
            ->setOptions($options);
        $this->table->addColumn($column);

        return new Column($column);
    }

    public function __get($name)
    {
        $options = $this->getOptions();

        return $options[$name] ?? null;
    }

    public function __set($name, $value)
    {
        $table = $this->table->getTable();

        $options = $table->getOptions();
        $options[$name] = $value;

        $table->setOptions($options);
    }

    public function __isset($name)
    {
        return isset($this->getOptions()[$name]);
    }

    private function getOptions(): array
    {
        return $this->table->getTable()->getOptions();
    }

    private function addIncrements(string $name, float $limit = null, bool $signed = false): Column
    {
        return $this->addInteger($name, $limit, true, $signed);
    }

    private function addInteger(string $name, float $limit = null, bool $identity = false, bool $signed = true): Column
    {
        return $this->addColumn($name, AdapterInterface::PHINX_TYPE_INTEGER, compact('limit', 'identity', 'signed'));
    }

    private function addText(string $name, float $limit = null): Column
    {
        return $this->addColumn($name, AdapterInterface::PHINX_TYPE_TEXT, compact('limit'));
    }
}
