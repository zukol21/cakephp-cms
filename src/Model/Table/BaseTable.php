<?php
namespace Cms\Model\Table;

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
     * @param bool $associated Contain associated categories.
     * @return \Cake\ORM\Entity
     * @throws \Cake\Datasource\Exception\RecordNotFoundException
     * @throws \InvalidArgumentException
     */
    public function getSite($id, $associated = false)
    {
        if (empty($id)) {
            throw new InvalidArgumentException('Site id or slug cannot be empty.');
        }

        $contain = [];
        if ($associated) {
            $contain['Categories'] = function ($q) {
                return $q->order(['Categories.lft' => 'ASC'])
                    ->applyOptions(['accessCheck' => false]);
            };
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
        ])->contain($contain);

        return $query->firstOrFail();
    }
}
