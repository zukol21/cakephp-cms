<?php
namespace Cms\Model\Table;

use Cake\ORM\Entity;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

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

        $this->table('sites');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Muffin/Slug.Slug');
        $this->addBehavior('Muffin/Trash.Trash');

        $this->hasMany('Cms.Categories');
        $this->hasMany('Cms.Articles');
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

        $contain = $this->_getContainAssociations($categories, $articles);

        $query = $this->find('all')
            ->limit(1)
            ->where(['Sites.id' => $id])
            ->orWhere(['Sites.slug' => $id])
            ->andWhere(['Sites.active' => true])
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
     * @param bool $categories Flag for containing associated categories.
     * @param bool $articles Flag for containing associated articles.
     * @return array
     */
    protected function _getContainAssociations($categories = false, $articles = false)
    {
        $result = [];

        if ((bool)$categories) {
            $result['Categories'] = function ($q) {
                return $q->order(['Categories.lft' => 'ASC']);
            };
        }

        if ((bool)$articles) {
            $result['Articles'] = function ($q) {
                return $q->order(['Articles.publish_date' => 'DESC'])
                    ->contain(['ArticleFeaturedImages']);
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
