<?php
namespace Cms\Model\Table;

use ArrayObject;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Event\Event;
use Cake\ORM\Entity;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;
use Cms\Model\Entity\Category;
use Cms\Model\Table\BaseTable;
use DateTime;
use InvalidArgumentException;

/**
 * Categories Model
 *
 * @property \Cake\ORM\Association\BelongsTo $ParentCategories
 * @property \Cake\ORM\Association\HasMany $ChildCategories
 * @property \Cake\ORM\Association\BelongsToMany $Articles
 */
class CategoriesTable extends BaseTable
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
        $this->addBehavior('Muffin/Trash.Trash');
        $this->addBehavior('Muffin/Slug.Slug', [
            'unique' => function (Entity $entity, $slug, $separator) {
                return $this->_uniqueSlug($entity, $slug, $separator);
            }
        ]);

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
        $rules->add($rules->existsIn(['parent_id'], 'ParentCategories'));

        return $rules;
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

    /**
     * Returns a unique slug.
     *
     * @param \Cake\ORM\Entity $entity Entity.
     * @param string $slug Slug.
     * @param string $separator Separator.
     * @return string Unique slug.
     */
    protected function _uniqueSlug(Entity $entity, $slug, $separator)
    {
        $behavior = $this->behaviors()->Slug;

        $primaryKey = $this->primaryKey();
        $field = $this->aliasField($behavior->config('field'));

        $conditions = [
            $field => $slug,
            'Categories.site_id' => $entity->site_id
        ];
        $conditions += $behavior->config('scope');
        if ($id = $entity->{$primaryKey}) {
            $conditions['NOT'][$this->_table->aliasField($primaryKey)] = $id;
        }

        $i = 0;
        $suffix = '';
        $length = $behavior->config('length');

        while (!$this->find('withTrashed', ['conditions' => $conditions])->isEmpty()) {
            $i++;
            $suffix = $separator . $i;
            if ($length && $length < mb_strlen($slug . $suffix)) {
                $slug = mb_substr($slug, 0, $length - mb_strlen($suffix));
            }
            $conditions[$field] = $slug . $suffix;
        }

        return $slug . $suffix;
    }
}
