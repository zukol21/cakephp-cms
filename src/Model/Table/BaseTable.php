<?php
namespace Cms\Model\Table;

use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\ORM\Table;
use InvalidArgumentException;

/**
 * Base Model
 *
 */
class BaseTable extends Table
{
    /**
     * Fetch and return Site by id or slug.
     *
     * @param string $id Site id or slug.
     * @return \Cake\ORM\Entity
     * @throws \Cake\Datasource\Exception\RecordNotFoundException
     * @throws \InvalidArgumentException
     */
    public function getSite($id)
    {
        if (empty($id)) {
            throw new InvalidArgumentException('Site id or slug cannot be empty.');
        }

        $query = $this->Sites->find('all', [
            'limit' => 1,
            'conditions' => [
                'OR' => [
                    'Sites.id' => $id,
                    'Sites.slug' => $id
                ],
                'Sites.active' => true
            ]
        ]);

        $result = $query->first();

        if (empty($result)) {
            throw new RecordNotFoundException('Site not found.');
        }

        return $result;
    }
}
