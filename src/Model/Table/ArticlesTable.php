<?php
namespace Cms\Model\Table;

use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Utility\Inflector;
use Cake\Validation\Validator;
use Cms\Model\Entity\Article;

/**
 * Articles Model
 *
 */
class ArticlesTable extends Table
{
    public $categories = [];

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('articles');
        $this->displayField('title');
        $this->primaryKey('id');
        $this->setCategories();

        $this->addBehavior('Timestamp');
        $this->hasMany('ArticleFeaturedImages', [
            'className' => 'Cms.ArticleFeaturedImages',
            'foreignKey' => 'foreign_key',
            'conditions' => [
                'ArticleFeaturedImages.model' => 'ArticleFeaturedImage'
            ]
        ]);
        $this->hasMany('ContentImages', [
            'className' => 'Cms.ContentImages',
            'foreignKey' => 'foreign_key',
            'conditions' => [
                'ContentImages.model' => 'ContentImage'
            ]
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
            ->requirePresence('title', 'create')
            ->notEmpty('title');

        $validator
            ->notEmpty('slug')
            ->add('slug', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->requirePresence('excerpt', 'create')
            ->notEmpty('excerpt');

        $validator
            ->requirePresence('content', 'create')
            ->notEmpty('content');

        $validator
            ->requirePresence('category', 'create')
            ->notEmpty('category');

        $validator
            ->date('publish_date')
            ->requirePresence('publish_date', 'create')
            ->notEmpty('publish_date');

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
        $rules->add($rules->isUnique(['slug']));
        return $rules;
    }

    /**
     * Returns the label of the category based on the provided valid key.
     *
     * @param  string $key Valid key of the categories property
     * @return string
     */
    public function getCategoryLabel($key = null)
    {
        if (empty($this->categories) && is_array($categories)) {
            throw new \RuntimeException('Categories property is empty or not array.');
        }

        if (!isset($this->categories[$key])) {
            return false;
        }

        return $this->categories[$key];
    }

    /**
     * Accessor method of categories property
     *
     * @return array
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Mutator method of categories property
     *
     * @return void
     */
    public function setCategories()
    {
        $this->categories = [
            'day-msg' => __d('primetel', 'Message of the day'),
            'calendar' => __d('primetel', 'Calendar'),
            'ads-promos' => __d('primetel', 'Advertising & Promotions'),
            'telecom' => __d('primetel', 'TELECOM News'),
        ];
    }

    /**
     * Reusable Query that return articles with the latest associated image.
     *
     * @param  Query  $query   To proceess it
     * @param  array  $options Extra options can be passed.
     * @return Query  $query   Return the query object which can be chained as usual.
     */
    public function findWithLatestImage(Query $query, array $options)
    {
        $query = $query
            ->find('all')
            ->contain(['ArticleFeaturedImages' => ['sort' => ['created' => 'DESC']]]);
        if (isset($options['id'])) {
            $query = $query
                ->where(['id' => $options['id']])
                ->first();
        }
        return $query;
    }

    public function beforeRules(Event $event, EntityInterface $entity, ArrayObject $options)
    {
        $slug = Inflector::slug(strtolower($entity->title));
        $notfound = false;
        $i = 0;
        do {
            if ($this->exists(['slug' => $slug])) {
                // First iteration.
                if (!$i) {
                    $slug .= '-';
                }
                $i++;
                $slug = substr($slug, 0, strrpos($slug, '-')) . '-' . $i;
            } else {
                $notfound = true;
            }
        } while (!$notfound);

        $entity->slug = $slug;
    }
}
