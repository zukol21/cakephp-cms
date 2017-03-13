<?php
namespace Cms\Model\Table;

use ArrayObject;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Event\Event;
use Cake\ORM\Entity;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cms\Model\Entity\Category;
use DateTime;
use InvalidArgumentException;

/**
 * Categories Model
 *
 * @property \Cake\ORM\Association\BelongsTo $ParentCategories
 * @property \Cake\ORM\Association\HasMany $ChildCategories
 * @property \Cake\ORM\Association\BelongsToMany $Articles
 */
class CategoriesTable extends Table
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

        $this->table('categories');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Tree');

        $this->belongsTo('Cms.Sites');
        $this->belongsTo('ParentCategories', [
            'className' => 'Cms.Categories',
            'foreignKey' => 'parent_id'
        ]);
        $this->hasMany('ChildCategories', [
            'className' => 'Cms.Categories',
            'foreignKey' => 'parent_id'
        ]);
        $this->hasMany('Cms.Articles', [
            'sort' => ['Articles.publish_date' => 'DESC'],
            'conditions' => ['Articles.publish_date <=' => new DateTime('now')]
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
            ->notEmpty('slug');

        $validator
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->requirePresence('site_id', 'create')
            ->notEmpty('site_id');

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
        $rules->add($rules->isUnique(['slug', 'site_id']));
        $rules->add($rules->existsIn(['parent_id'], 'ParentCategories'));

        return $rules;
    }

    /**
     * beforeMarshal callback
     *
     * @param \Cake\Event\Event $event Event object
     * @param \ArrayAccess $data Request data
     * @param \ArrayAccess $options Query options
     * @return void
     */
    public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options)
    {
        $this->addBehavior('Muffin/Slug.Slug', [
            'scope' => [
                'Categories.site_id' => $data['site_id']
            ]
        ]);
    }

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

    /**
     * Fetch and return Category by id or slug and associated Site id.
     *
     * @param string $id Site id or slug.
     * @param \Cake\ORM\Entity $site Site entity.
     * @param array $contain Contain associations list (optional).
     * @return \Cake\ORM\Entity
     * @throws \Cake\Datasource\Exception\RecordNotFoundException
     * @throws \InvalidArgumentException
     */
    public function getCategoryBySite($id, Entity $site, array $contain = [])
    {
        if (empty($id)) {
            throw new InvalidArgumentException('Category id or slug cannot be empty.');
        }

        $query = $this->find('all', [
            'limit' => 1,
            'conditions' => [
                'OR' => [
                    'Categories.id' => $id,
                    'Categories.slug' => $id
                ],
                'Categories.site_id' => $site->id
            ],
            'contain' => $contain
        ]);

        $result = $query->first();

        if (empty($result)) {
            throw new RecordNotFoundException('Category not found.');
        }

        return $result;
    }
}
