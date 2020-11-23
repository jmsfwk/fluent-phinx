<?php

namespace Tests\FluentPhinx\Schema;

use jmsfwk\FluentPhinx\Schema\Column as FluentColumn;
use Phinx\Db\Table\Column;
use PHPUnit\Framework\TestCase;

class ColumnTest extends TestCase
{
    /** @var Column */
    private $phinx;
    /** @var FluentColumn */
    private $column;

    protected function setUp(): void
    {
        parent::setUp();
        $this->phinx = new Column();
        $this->column = new FluentColumn($this->phinx);
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
}
