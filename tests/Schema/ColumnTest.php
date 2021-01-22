<?php

namespace Tests\FluentPhinx\Schema;

use jmsfwk\FluentPhinx\Schema\Blueprint;
use jmsfwk\FluentPhinx\Schema\Column as FluentColumn;
use Phinx\Db\Table;
use Phinx\Db\Table\Column;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ColumnTest extends TestCase
{
    /** @var Blueprint|MockObject */
    private $blueprint;
    /** @var Column */
    private $phinx;
    /** @var FluentColumn */
    private $column;

    protected function setUp(): void
    {
        parent::setUp();
        $this->blueprint = $this->createMock(Blueprint::class);
        $this->phinx = new Column();
        $this->column = new FluentColumn($this->phinx, $this->blueprint);
    }

    /** @test */
    public function after()
    {
        $this->column->after('::column::');

        self::assertEquals('::column::', $this->phinx->getAfter());
    }

    /** @test */
    public function autoIncrement()
    {
        $this->column->autoIncrement();

        self::assertTrue($this->phinx->isIdentity());
    }

    /** @test */
    public function charset()
    {
        $this->phinx->setType(Column::CHAR);

        $this->column->charset('::charset::');

        self::assertEquals('::charset::', $this->phinx->getEncoding());
    }

    /** @test */
    public function collation()
    {
        $this->phinx->setType(Column::CHAR);

        $this->column->collation('::collation::');

        self::assertEquals('::collation::', $this->phinx->getCollation());
    }

    /** @test */
    public function comment()
    {
        $this->column->comment('::comment::');

        self::assertEquals('::comment::', $this->phinx->getComment());
    }

    /** @test */
    public function default()
    {
        $this->column->default('::default::');

        self::assertEquals('::default::', $this->phinx->getDefault());
    }

    /** @test */
    public function from()
    {
        $this->column->from(40);

        self::assertEquals(40, $this->phinx->getIncrement());
    }

    /** @test */
    public function nullable()
    {
        $this->column->nullable(true);

        self::assertTrue($this->phinx->getNull());
    }

    /** @test */
    public function unsigned()
    {
        $this->column->unsigned();

        self::assertFalse($this->phinx->getSigned());
    }

    /** @test */
    public function useCurrent()
    {
        $this->column->useCurrent();

        self::assertEquals('CURRENT_TIMESTAMP', $this->phinx->getDefault());
    }

    /** @test */
    public function index()
    {
        $phinx = (new Column())->setName('::column::');
        $column = new FluentColumn($phinx, $this->blueprint);

        $this->blueprint->expects(self::once())
            ->method('index')
            ->with('::column::', null);

        $column->index();
    }

    /** @test */
    public function index_with_name()
    {
        $phinx = (new Column())->setName('::column::');
        $column = new FluentColumn($phinx, $this->blueprint);

        $this->blueprint->expects(self::once())
            ->method('index')
            ->with('::column::', '::name::');

        $column->index('::name::');
    }

    /** @test */
    public function unique()
    {
        $phinx = (new Column())->setName('::column::');
        $column = new FluentColumn($phinx, $this->blueprint);

        $this->blueprint->expects(self::once())
            ->method('unique')
            ->with('::column::', null);

        $column->unique();
    }

    /** @test */
    public function unique_with_name()
    {
        $phinx = (new Column())->setName('::column::');
        $column = new FluentColumn($phinx, $this->blueprint);

        $this->blueprint->expects(self::once())
            ->method('unique')
            ->with('::column::', '::name::');

        $column->unique('::name::');
    }

    /** @test */
    public function primary()
    {
        $table = new Table('::table::');
        $phinx = (new Column())->setName('::column::');
        $column = new FluentColumn($phinx, new Blueprint($table));

        $column->primary();

        self::assertEquals('::column::', $table->getOptions()['primary_key']);
    }
}
