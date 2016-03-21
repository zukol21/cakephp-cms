<?php
use Migrations\AbstractMigration;

class CreateJoinTable extends AbstractMigration
{

    public $autoId = false;

    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('articles_categories');
        $table->addColumn('article_id', 'uuid', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('category_id', 'uuid', [
            'default' => null,
            'null' => false,
        ]);
        $table->addForeignKey('article_id', 'articles', 'id');
        $table->addForeignKey('category_id', 'categories', 'id');
        $table->addPrimaryKey([
            'article_id', 'category_id'
        ]);
        $table->create();
    }
}
