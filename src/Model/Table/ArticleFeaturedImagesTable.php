<?php
namespace Cms\Model\Table;

use Burzum\FileStorage\Model\Table\ImageStorageTable;

class ArticleFeaturedImagesTable extends ImageStorageTable
{
    /**
     * Save the entity to the file storage table.
     * Please note this is a child of the ImageStorageTable.
     *
     * @see ImageStorageTable class
     * @param  [type] $articleId [description]
     * @param  [type] $entity    [description]
     * @return [type]            [description]
     */
    public function uploadImage($articleId, $entity)
    {
        $entity = $this->patchEntity($entity, [
            'adapter' => 'Local',
            'model' => 'ArticleFeaturedImage',
            'foreign_key' => $articleId
        ]);

        return $this->save($entity);
    }
}
