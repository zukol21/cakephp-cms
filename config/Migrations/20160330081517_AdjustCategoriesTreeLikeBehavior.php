<?php
use Migrations\AbstractMigration;

class AdjustCategoriesTreeLikeBehavior extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('categories');
        $table
            ->addColumn('parent_id', 'uuid', [
                'after' => 'name',
                'default' => null,
                'null' => true,
            ])
            ->addColumn('lft', 'integer', [
                'after' => 'parent_id',
                'default' => null,
                'null' => false,
            ])
            ->addColumn('rght', 'integer', [
                'after' => 'lft',
                'default' => null,
                'null' => false,
            ])
            ->update();
    }
}
