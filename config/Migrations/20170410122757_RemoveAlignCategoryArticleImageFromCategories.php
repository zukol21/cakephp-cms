<?php
use Migrations\AbstractMigration;

class RemoveAlignCategoryArticleImageFromCategories extends AbstractMigration
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
        $table->removeColumn('align_category_article_image');
        $table->update();
    }
}
