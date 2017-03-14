<?php
namespace Cms\Model\Table;

use ArrayObject;
use Cake\Collection\Collection;
use Cake\Core\Configure;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Utility\Hash;
use Cake\Utility\Inflector;
use Cake\Validation\Validator;
use Cms\Model\Entity\Article;

/**
 * Articles Model
 *
 */
class ArticlesTable extends Table
{

    /**
     * Related articles limit
     * @var int
     */
    public $related;

    /**
     * This variable holds the associated table which
     * are mostly used with this table. It will be used
     * by the contain function of the Query Builder.
     * @see Query::contain()
     * @var array
     */
    protected $_contain = [];

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
        $this->setContain();

        $this->addBehavior('Timestamp');
        $this->addBehavior('Muffin/Slug.Slug');
        $this->addBehavior('Muffin/Trash.Trash');

        $this->hasMany('ArticleFeaturedImages', [
            'className' => 'Cms.ArticleFeaturedImages',
            'foreignKey' => 'foreign_key',
            'conditions' => [
                'ArticleFeaturedImages.model' => 'ArticleFeaturedImage'
            ],
            'sort' => ['ArticleFeaturedImages.created' => 'DESC']
        ]);
        $this->hasMany('ContentImages', [
            'className' => 'Cms.ContentImages',
            'foreignKey' => 'foreign_key',
            'conditions' => [
                'ContentImages.model' => 'ContentImage'
            ]
        ]);
        $this->belongsTo('Cms.Sites');
        $this->belongsTo('Cms.Categories');
        $this->setRelated();
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
            ->requirePresence('content', 'create')
            ->allowEmpty('content');

        $validator
            ->requirePresence('category_id', 'create')
            ->notEmpty('category_id');

        $validator
            ->dateTime('publish_date')
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
            ->contain($this->getContain());
        if (isset($options['id'])) {
            $query = $query
                ->where(['Articles.id' => $options['id']])
                ->first();
        }

        return $query;
    }

    /**
     * Reusable query to find article per given category.
     * Also, related featured images can be provided by sending the corresponding option.
     *
     * By default, `$options` will recognize the following keys:
     *
     * - category
     *
     *
     * @param  Query  $query   Raw query object
     * @param  array  $options Set of options
     * @return Query  $query   Manipulated query object
     */
    public function findByCategory(Query $query, array $options)
    {
        if (empty($options['category'])) {
            return $query;
        }

        $query->find('all');
        $query->contain($this->getContain());
        $query->matching('Categories', function ($q) use ($options) {
            return $q->where(['Categories.slug' => $options['category']]);
        });

        return $query;
    }

    /**
     * Reusable query to find related articles.
     *
     * By default, `$options` will recognize the following keys:
     *
     * - article - just the entity
     * - limit - number of related articles.
     *
     * @param  Query  $query   Raw query object
     * @param  array  $options Set of options
     * @return Query|bool  $query   Manipulated query object - False otherwise.
     */
    public function findRelated(Query $query, array $options)
    {
        $query->contain($this->getContain());
        $article = Hash::get($options, 'article');
        if (!$article) {
            return false;
        }
        $limit = Hash::get($options, 'limit');
        $limit = $limit ?: $this->related;
        $collection = new Collection($article['categories']);
        $collection = $collection->extract('slug');
        $categories = $collection->toArray();
        if (empty($categories)) {
            return false;
        }

        return $query
                ->find('all')
                ->distinct(['Articles.slug'])
                ->where(['Articles.slug <>' => $article->get('slug')])
                ->contain($this->getContain())
                ->matching('Categories', function ($q) use ($categories) {
                    return $q
                        ->where(['Categories.slug IN' => $categories]);
                })
                ->order(['Articles.publish_date' => 'DESC'])
                ->limit($limit);
    }

    /**
     * Search function which search the given fields.
     * Options:
     * - term, the search term - required
     * - fields, It is the schema fields could be a string or array - required
     *
     * @param  Query  $query   Raw Query
     * @param  array  $options functions's options
     * @return Query           Raw|Manipulated Query
     */
    public function findSearch(Query $query, array $options)
    {
        $fields = Hash::get($options, 'fieldNames');
        $term = Hash::get($options, 'term');

        if (is_null($term) || is_null($fields)) {
            return $query;
        }

        //Loads other fields and related tables.
        $query = $this->find('withLatestImage');

        if (is_string($fields)) {
            $field = $fields;
            $query = $query->where(function ($exp, $q) use ($field, $term) {
                return $exp->like($field, '%' . $term . '%');
            });
        }

        if (is_array($fields)) {
            foreach ($fields as $index => $field) {
                // First iteration we need to call where() and then for the rest fields
                // the orWhere()
                if (!$index) {
                    $function = 'where';
                } else {
                    $function = 'orWhere';
                }
                $query = $query->{$function}(function ($exp, $q) use ($field, $term) {
                    return $exp->like($field, '%' . $term . '%');
                });
            }
        }

        return $query;
    }

    /**
     * Returns the associated tables.
     *
     * @return array
     */
    public function getContain()
    {
        return $this->_contain;
    }

    /**
     * Sets the associated tables.
     *
     * @param array $contain Conditions that will be
     * @param bool $override Override flag
     * passed to contain function of Query builder.
     * @see Query::contain()
     * @return void
     */
    public function setContain($contain = [], $override = true)
    {
        $default = [
            'Categories' => [],
            'ArticleFeaturedImages' => ['sort' => ['created' => 'DESC']],
        ];
        if (empty($contain) || $override === true) {
            $contain += $default;
        }

        $this->_contain = $contain;
    }

    /**
     * Return searchable fields.
     *
     * @return array Searchable fields
     */
    public function searchableFields()
    {
        return ['title', 'slug', 'excerpt', 'content'];
    }

    /**
     * Setter method of related articles limit.
     *
     * @param  int $limit Number of related articles.
     * @return void
     */
    public function setRelated($limit = null)
    {
        if (is_numeric($limit)) {
            $this->related = $limit;
        } else {
            $this->related = Configure::read('Cms.articles.related');
        }
    }

    /**
     * Returns the related articles limit.
     *
     * @return int related articles.
     */
    public function getRelated()
    {
        return $this->related;
    }
}
