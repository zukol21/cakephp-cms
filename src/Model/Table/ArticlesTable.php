<?php
namespace Cms\Model\Table;

use ArrayObject;
use Cake\Collection\Collection;
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
     * Number of related articles.
     */
    const RELATED_LIMIT = 5;

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
        $this->belongsToMany('Categories', [
            'foreignKey' => 'article_id',
            'targetForeignKey' => 'category_id',
            'joinTable' => 'articles_categories',
            'className' => 'Cms.Categories'
        ]);
        $this->addBehavior('Muffin/Slug.Slug');
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
            ->notEmpty('content');

        $validator
            ->requirePresence('categories', 'create')
            ->notEmpty('categories');

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
                ->where(['id' => $options['id']])
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
     * - categories
     * An array of categories slugs.
     *
     * @param  Query  $query   Raw query object
     * @param  array  $options Set of options
     * @return Query  $query   Manipulated query object
     */
    public function findRelated(Query $query, array $options)
    {
        $query->contain($this->getContain());
        $article = Hash::get($options, 'article');
        if (!$article) {
            return false;
        }
        $limit = Hash::get($options, 'limit');
        $limit = $limit ?: self::RELATED_LIMIT;
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
                ->limit($limit);
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
}
