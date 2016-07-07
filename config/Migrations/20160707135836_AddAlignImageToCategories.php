<?php
use Migrations\AbstractMigration;

class AddAlignImageToCategories extends AbstractMigration
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
        $table->addColumn('align_category_article_image', 'string', [
            'after' => 'rght',
            'default' => null,
            'null' => true,
        ]);
        $table->update();
    }
}
