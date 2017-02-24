<?php
use Migrations\AbstractMigration;

class AddCategoryIdToArticles extends AbstractMigration
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
        $table = $this->table('articles');
        $table->addColumn('category_id', 'uuid', [
            'default' => null,
            'null' => false,
        ]);
        $table->update();
    }
}
