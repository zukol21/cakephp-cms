<?php
/**
 * Copyright (c) Qobo Ltd. (https://www.qobo.biz)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Qobo Ltd. (https://www.qobo.biz)
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
namespace Cms\Model\Table;

use Cake\ORM\Entity;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use InvalidArgumentException;

/**
 * Sites Model
 */
class SitesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('qobo_cms_sites');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Muffin/Slug.Slug');
        $this->addBehavior('Muffin/Trash.Trash');

        $this->hasMany('Cms.Categories', [
            'foreignKey' => 'site_id',
        ]);
        $this->hasMany('Cms.Articles', [
            'foreignKey' => 'site_id',
            'sort' => ['Articles.publish_date' => 'DESC']
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->uuid('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('name', 'create')
            ->notEmpty('name')
            ->add('name', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->notEmpty('slug')
            ->add('slug', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->boolean('active')
            ->requirePresence('active', 'create')
            ->notEmpty('active');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['name']));
        $rules->add($rules->isUnique(['slug']));

        return $rules;
    }

    /**
     * Fetch and return Site by id or slug.
     *
     * @param string $id Site id or slug.
     * @param bool $categories Flag for containing associated categories.
     * @param bool $articles Flag for containing associated articles.
     * @return \Cake\ORM\Entity
     * @throws \Cake\Datasource\Exception\RecordNotFoundException
     * @throws \InvalidArgumentException
     */
    public function getSite($id, $categories = false, $articles = false)
    {
        if (empty($id)) {
            throw new InvalidArgumentException('Site id or slug cannot be empty.');
        }

        if (!is_string($id)) {
            throw new InvalidArgumentException('Site id or slug must be a string.');
        }

        $contain = $this->_getContainAssociations($id, $categories, $articles);

        $query = $this->find('all')
            ->where([
                'AND' => [
                    'Sites.active' => true,
                    'OR' => [
                        'Sites.id' => $id,
                        'Sites.slug' => $id
                    ]
                ]
            ])
            ->limit(1)
            ->contain($contain);

        $site = $query->firstOrFail();

        // skip if site object has no categories
        if (!(bool)$categories || !$site->categories) {
            return $site;
        }

        $this->_addNodeToCategories($site);

        return $site;
    }

    /**
     * Contain associations getter.
     *
     * Categories are included by default, and if accessed
     * table is SitesTable, include associated articles.
     *
     * @param string $id Site id or slug.
     * @param bool $categories Flag for containing associated categories.
     * @param bool $articles Flag for containing associated articles.
     * @return array
     */
    protected function _getContainAssociations($id, $categories = false, $articles = false)
    {
        $result = [];

        if ((bool)$categories) {
            $result['Categories'] = function ($q) {
                return $q->order(['Categories.lft' => 'ASC']);
            };
        }

        if ((bool)$articles) {
            $result['Articles'] = function ($q) use ($id) {
                return $q->contain(['ArticleFeaturedImages'])
                    ->applyOptions(['site_id' => $id]);
            };
        }

        return $result;
    }

    /**
     * Adds node property to site's associated categories.
     *
     * @param \Cake\ORM\Entity $site Site object
     * @return void
     */
    protected function _addNodeToCategories(Entity $site)
    {
        $tree = $this->Categories->getTreeList($site->id);

        if (empty($tree)) {
            return;
        }

        foreach ($site->categories as $category) {
            if (!array_key_exists($category->id, $tree)) {
                continue;
            }
            $category->node = $tree[$category->id];
        }
    }
}
