<?php

namespace Tests\FluentPhinx\Schema;

use jmsfwk\FluentPhinx\Schema\Blueprint;
use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Db\Table;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class BlueprintTest extends TestCase
{
    /** @var Table|MockObject */
    private $mockTable;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockTable = $this->createMock(Table::class);
    }

    /** @test */
    public function can_set_options()
    {
        $table = new Table('::name::');
        $blueprint = new Blueprint($table);

        $blueprint->comment = '::comment::';

        self::assertArrayHasKey('comment', $table->getOptions());
        self::assertEquals('::comment::', $table->getOptions()['comment']);
    }

    /** @test */
    public function macros_can_call_methods_on_the_blueprint()
    {
        Blueprint::macro('timestamp', function (string $name) {
            /** @var Blueprint $this */
            return $this->addColumn($name, '::type::');
        });
        $blueprint = new Blueprint($this->mockTable);

        self::expectColumn($this->mockTable, '::column::', '::type::');

        $blueprint->timestamp('::column::');
    }

    /** @test */
    public function macros_can_set_properties_on_the_blueprint()
    {
        Blueprint::macro('id', function () {
            /** @var Blueprint $this */
            $this->id = false;
        });
        $table = new Table('::name::');
        $blueprint = new Blueprint($table);

        $blueprint->id();

        self::assertEquals(['id' => false], $table->getOptions());
    }

    /** @test */
    public function binary()
    {
        $blueprint = new Blueprint($this->mockTable);

        self::expectColumn($this->mockTable, '::column::', 'binary');

        $blueprint->binary('::column::');
    }

    /** @test */
    public function boolean()
    {
        $blueprint = new Blueprint($this->mockTable);

        self::expectColumn($this->mockTable, '::column::', 'boolean');

        $blueprint->boolean('::column::');
    }

    /** @test */
    public function char()
    {
        $blueprint = new Blueprint($this->mockTable);

        self::expectColumn($this->mockTable, '::column::', 'char', [
            'limit' => 15,
        ]);

        $blueprint->char('::column::', 15);
    }

    /** @test */
    public function date()
    {
        $blueprint = new Blueprint($this->mockTable);

        self::expectColumn($this->mockTable, '::column::', 'date');

        $blueprint->date('::column::');
    }

    /** @test */
    public function dateTime()
    {
        $blueprint = new Blueprint($this->mockTable);

        self::expectColumn($this->mockTable, '::column::', 'datetime');

        $blueprint->dateTime('::column::');
    }

    /** @test */
    public function dateTimeTz()
    {
        $blueprint = new Blueprint($this->mockTable);

        self::expectColumn($this->mockTable, '::column::', 'datetime', [
            'timezone' => true,
        ]);

        $blueprint->dateTimeTz('::column::');
    }

    /** @test */
    public function decimal()
    {
        $blueprint = new Blueprint($this->mockTable);

        self::expectColumn($this->mockTable, '::column::', 'decimal', [
            'precision' => 4,
            'scale' => 2,
        ]);

        $blueprint->decimal('::column::', 4, 2);
    }

    /** @test */
    public function double()
    {
        $blueprint = new Blueprint($this->mockTable);

        self::expectColumn($this->mockTable, '::column::', 'double', [
            'precision' => 4,
            'scale' => 2,
        ]);

        $blueprint->double('::column::', 4, 2);
    }

    /** @test */
    public function enum()
    {
        $blueprint = new Blueprint($this->mockTable);

        self::expectColumn($this->mockTable, '::column::', 'enum', [
            'values' => [1, 2, 3],
        ]);

        $blueprint->enum('::column::', [1, 2, 3]);
    }

    /** @test */
    public function float()
    {
        $blueprint = new Blueprint($this->mockTable);

        self::expectColumn($this->mockTable, '::column::', 'float', [
            'precision' => 4,
            'scale' => 2,
        ]);

        $blueprint->float('::column::', 4, 2);
    }

    /** @test */
    public function geometry()
    {
        $blueprint = new Blueprint($this->mockTable);

        self::expectColumn($this->mockTable, '::column::', 'geometry');

        $blueprint->geometry('::column::');
    }

    /** @test */
    public function increments()
    {
        $blueprint = new Blueprint($this->mockTable);

        self::expectColumn($this->mockTable, '::column::', 'integer', [
            'identity' => true,
            'signed' => false,
        ]);

        $blueprint->increments('::column::');
    }

    /** @test */
    public function smallIncrements()
    {
        $blueprint = new Blueprint($this->mockTable);

        self::expectColumn($this->mockTable, '::column::', 'integer', [
            'identity' => true,
            'limit' => MysqlAdapter::INT_SMALL,
            'signed' => false,
        ]);

        $blueprint->smallIncrements('::column::');
    }

    /** @test */
    public function mediumIncrements()
    {
        $blueprint = new Blueprint($this->mockTable);

        self::expectColumn($this->mockTable, '::column::', 'integer', [
            'identity' => true,
            'limit' => MysqlAdapter::INT_MEDIUM,
            'signed' => false,
        ]);

        $blueprint->mediumIncrements('::column::');
    }

    /** @test */
    public function bigIncrements()
    {
        $blueprint = new Blueprint($this->mockTable);

        self::expectColumn($this->mockTable, '::column::', 'integer', [
            'identity' => true,
            'limit' => MysqlAdapter::INT_BIG,
            'signed' => false,
        ]);

        $blueprint->bigIncrements('::column::');
    }

    /** @test */
    public function integer()
    {
        $blueprint = new Blueprint($this->mockTable);

        self::expectColumn($this->mockTable, '::column::', 'integer');

        $blueprint->integer('::column::');
    }

    /** @test */
    public function tinyInteger()
    {
        $blueprint = new Blueprint($this->mockTable);

        self::expectColumn($this->mockTable, '::column::', 'integer', [
            'limit' => MysqlAdapter::INT_TINY,
        ]);

        $blueprint->tinyInteger('::column::');
    }

    /** @test */
    public function smallInteger()
    {
        $blueprint = new Blueprint($this->mockTable);

        self::expectColumn($this->mockTable, '::column::', 'integer', [
            'limit' => MysqlAdapter::INT_SMALL,
        ]);

        $blueprint->smallInteger('::column::');
    }

    /** @test */
    public function mediumInteger()
    {
        $blueprint = new Blueprint($this->mockTable);

        self::expectColumn($this->mockTable, '::column::', 'integer', [
            'limit' => MysqlAdapter::INT_MEDIUM,
        ]);

        $blueprint->mediumInteger('::column::');
    }

    /** @test */
    public function bigInteger()
    {
        $blueprint = new Blueprint($this->mockTable);

        self::expectColumn($this->mockTable, '::column::', 'integer', [
            'limit' => MysqlAdapter::INT_BIG,
        ]);

        $blueprint->bigInteger('::column::');
    }

    /** @test */
    public function json()
    {
        $blueprint = new Blueprint($this->mockTable);

        self::expectColumn($this->mockTable, '::column::', 'json');

        $blueprint->json('::column::');
    }

    /** @test */
    public function jsonb()
    {
        $blueprint = new Blueprint($this->mockTable);

        self::expectColumn($this->mockTable, '::column::', 'jsonb');

        $blueprint->jsonb('::column::');
    }

    /** @test */
    public function lineString()
    {
        $blueprint = new Blueprint($this->mockTable);

        self::expectColumn($this->mockTable, '::column::', 'linestring');

        $blueprint->lineString('::column::');
    }

    /** @test */
    public function macAddress()
    {
        $blueprint = new Blueprint($this->mockTable);

        self::expectColumn($this->mockTable, '::column::', 'macaddr');

        $blueprint->macAddress('::column::');
    }

    /** @test */
    public function point()
    {
        $blueprint = new Blueprint($this->mockTable);

        self::expectColumn($this->mockTable, '::column::', 'point');

        $blueprint->point('::column::');
    }

    /** @test */
    public function polygon()
    {
        $blueprint = new Blueprint($this->mockTable);

        self::expectColumn($this->mockTable, '::column::', 'polygon');

        $blueprint->polygon('::column::');
    }

    /** @test */
    public function set()
    {
        $blueprint = new Blueprint($this->mockTable);

        self::expectColumn($this->mockTable, '::column::', 'set', [
            'values' => [1, 2, 3]
        ]);

        $blueprint->set('::column::', [1, 2, 3]);
    }

    /** @test */
    public function string()
    {
        $blueprint = new Blueprint($this->mockTable);

        self::expectColumn($this->mockTable, '::column::', 'string');

        $blueprint->string('::column::');
    }

    /** @test */
    public function string_with_length()
    {
        $blueprint = new Blueprint($this->mockTable);

        self::expectColumn($this->mockTable, '::column::', 'string', [
            'limit' => 100,
        ]);

        $blueprint->string('::column::', 100);
    }

    /** @test */
    public function time()
    {
        $blueprint = new Blueprint($this->mockTable);

        self::expectColumn($this->mockTable, '::column::', 'time');

        $blueprint->time('::column::');
    }

    /** @test */
    public function text()
    {
        $blueprint = new Blueprint($this->mockTable);

        self::expectColumn($this->mockTable, '::column::', 'text');

        $blueprint->text('::column::');
    }

    /** @test */
    public function mediumText()
    {
        $blueprint = new Blueprint($this->mockTable);

        self::expectColumn($this->mockTable, '::column::', 'text', [
            'limit' => MysqlAdapter::TEXT_MEDIUM,
        ]);

        $blueprint->mediumText('::column::');
    }

    /** @test */
    public function longText()
    {
        $blueprint = new Blueprint($this->mockTable);

        self::expectColumn($this->mockTable, '::column::', 'text', [
            'limit' => MysqlAdapter::TEXT_LONG,
        ]);

        $blueprint->longText('::column::');
    }

    /* Indexes */

    /** @test */
    public function index()
    {
        $blueprint = new Blueprint($this->mockTable);

        self::expectIndex($this->mockTable, '::column::', [
            'name' => null,
        ]);

        $blueprint->index('::column::');
    }

    /** @test */
    public function index_with_name()
    {
        $blueprint = new Blueprint($this->mockTable);

        self::expectIndex($this->mockTable, '::column::', [
            'name' => '::name::',
        ]);

        $blueprint->index('::column::', '::name::');
    }

    /** @test */
    public function index_with_multiple_columns()
    {
        $blueprint = new Blueprint($this->mockTable);

        self::expectIndex($this->mockTable, ['::column1::', '::column2::'], [
            'name' => null,
        ]);

        $blueprint->index(['::column1::', '::column2::']);
    }

    /** @test */
    public function unique()
    {
        $blueprint = new Blueprint($this->mockTable);

        self::expectIndex($this->mockTable, '::column::', [
            'name' => null,
            'unique' => true,
        ]);

        $blueprint->unique('::column::');
    }

    /** @test */
    public function unique_with_name()
    {
        $blueprint = new Blueprint($this->mockTable);

        self::expectIndex($this->mockTable, '::column::', [
            'name' => '::name::',
            'unique' => true,
        ]);

        $blueprint->unique('::column::', '::name::');
    }

    /** @test */
    public function unique_with_multiple_columns()
    {
        $blueprint = new Blueprint($this->mockTable);

        self::expectIndex($this->mockTable, ['::column1::', '::column2::'], [
            'name' => null,
            'unique' => true,
        ]);

        $blueprint->unique(['::column1::', '::column2::']);
    }

    /** @test */
    public function foreign()
    {
        $blueprint = new Blueprint($this->mockTable);

        self::expectForeignKey($this->mockTable, '::column::', '::on::', '::references::');

        $blueprint->foreign('::column::')->references('::references::')->on('::on::');
    }

    /** @test */
    public function foreign_with_on_update_and_on_delete()
    {
        $blueprint = new Blueprint($this->mockTable);

        self::expectForeignKey($this->mockTable, '::column::', '::on::', '::references::', [
            'update' => 'cascade',
            'delete' => 'restrict',
        ]);

        $blueprint->foreign('::column::')
            ->references('::references::')
            ->on('::on::')
            ->onUpdate('cascade')
            ->onDelete('restrict');
    }

    private static function expectColumn($table, string $name, string $type, array $options = []): void
    {
        $column = (new Table\Column())->setName($name)->setType($type)->setOptions($options);

        $table->expects(self::once())->method('addColumn')->with($column);
    }

    private static function expectIndex(MockObject $table, $columns, array $options = []): void
    {
        $table->expects(self::once())->method('addIndex')->with($columns, $options);
    }

    private static function expectForeignKey(
        MockObject $table,
        $columns,
        string $referencedTable,
        string $referencedColumn,
        array $options = []
    ): void {
        $table->expects(self::once())
            ->method('addForeignKey')
            ->with($columns, $referencedTable, $referencedColumn, $options);
    }
}
