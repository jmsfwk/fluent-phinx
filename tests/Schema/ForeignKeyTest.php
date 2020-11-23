<?php

namespace Tests\FluentPhinx\Schema;

use jmsfwk\FluentPhinx\Schema\Blueprint;
use Phinx\Db\Table;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ForeignKeyTest extends TestCase
{
    /** @var Table|MockObject */
    private $mockTable;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockTable = $this->createMock(Table::class);
    }

    /** @test */
    public function can_define_foreign_key()
    {
        $blueprint = new Blueprint($this->mockTable);

        $this->mockTable->expects(self::once())->method('addForeignKey')
            ->with('user_id', 'users', 'id', []);

        $blueprint->foreign('user_id')
            ->references('id')
            ->on('users');
    }

    /** @test */
    public function can_use_multiple_columns()
    {
        $blueprint = new Blueprint($this->mockTable);

        $this->mockTable->expects(self::once())->method('addForeignKey')
            ->with(['user_id', 'company_id'], 'users', ['id', 'company_id'], []);

        $blueprint->foreign(['user_id', 'company_id'])
            ->references(['id', 'company_id'])
            ->on('users');
    }

    /** @test */
    public function can_set_on_update_actions()
    {
        $blueprint = new Blueprint($this->mockTable);

        $this->mockTable->expects(self::once())->method('addForeignKey')
            ->with('::column::', '::table::', '::reference::', ['update' => 'set null']);

        $blueprint->foreign('::column::')
            ->references('::reference::')
            ->on('::table::')
            ->onUpdate('set null');
    }

    /** @test */
    public function can_set_on_delete_actions()
    {
        $blueprint = new Blueprint($this->mockTable);

        $this->mockTable->expects(self::once())->method('addForeignKey')
            ->with('::column::', '::table::', '::reference::', ['delete' => 'cascade']);

        $blueprint->foreign('::column::')
            ->references('::reference::')
            ->on('::table::')
            ->onDelete('cascade');
    }

    /** @test */
    public function can_set_the_index_name()
    {
        $blueprint = new Blueprint($this->mockTable);

        $this->mockTable->expects(self::once())->method('addForeignKey')
            ->with('::column::', null, null, ['constraint' => '::index name::']);

        $blueprint->foreign('::column::', '::index name::');
    }
}
