<?php
use Migrations\AbstractMigration;

class RemoveTrashedFromCategories extends AbstractMigration
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

        // permanently delete trashed records, before trashed column is dropped
        $result = $this->execute('DELETE FROM categories WHERE trashed IS NOT NULL');

        // check against boolean false, as $result might be 0 if no rows have been affected
        if (false !== $result) {
            $table->removeColumn('trashed');
            $table->update();
        }
    }
}
