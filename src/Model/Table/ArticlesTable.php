<?php
namespace Cms\Model\Table;

use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\ORM\Entity;
use Cake\ORM\Query;
use Cake\ORM\ResultSet;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Utility\Inflector;
use Cake\Validation\Validator;
use InvalidArgumentException;

/**
 * Articles Model
 *
 */
class ArticlesTable extends Table
{
    /**
     * Article types list.
     *
     * @var array
     */
    protected $_types = [];

    /**
     * Type fields default.
     *
     * @var array
     */
    protected $_fieldDefaults = [
        'renderAs' => 'text',
        'required' => true,
        'editor' => false
    ];

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

        $this->addBehavior('Timestamp');
        $this->addBehavior('Muffin/Trash.Trash');
        $this->addBehavior('Muffin/Slug.Slug', [
            'unique' => function (Entity $entity, $slug, $separator) {
                return $this->_uniqueSlug($entity, $slug, $separator);
            }
        ]);

        $this->hasMany('ArticleFeaturedImages', [
            'className' => 'Cms.ArticleFeaturedImages',
            'foreignKey' => 'foreign_key',
            'conditions' => [
                'ArticleFeaturedImages.model' => 'ArticleFeaturedImage'
            ],
            'sort' => ['ArticleFeaturedImages.created' => 'DESC']
        ]);
        $this->belongsTo('Cms.Sites');
        $this->belongsTo('Cms.Categories');
        $this->belongsTo('Author', [
            'className' => 'CakeDC/Users.Users',
            'foreignKey' => 'created_by'
        ]);

        $this->belongsTo('Editor', [
            'className' => 'CakeDC/Users.Users',
            'foreignKey' => 'modified_by'
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
            ->requirePresence('content', 'create')
            ->allowEmpty('content');

        $validator
            ->requirePresence('category_id', 'create')
            ->notEmpty('category_id');

        $validator
            ->dateTime('publish_date')
            ->requirePresence('publish_date', 'create')
            ->notEmpty('publish_date');

        $validator
            ->requirePresence('site_id', 'create')
            ->notEmpty('site_id');

        $validator
            ->requirePresence('type', 'create')
            ->notEmpty('type');

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
     * {@inheritDoc}
     */
    public function beforeFind(Event $event, Query $query, $options)
    {
        $siteId = !empty($options['site_id']) ? $options['site_id'] : null;

        $event = new Event('Cms.Articles.showUnpublished', $this, ['siteId' => $siteId]);
        $this->eventManager()->dispatch($event);

        $query->order(['Articles.publish_date' => 'DESC']);
        if (!(bool)$event->result) {
            $query->where(['Articles.publish_date <=' => Time::now()]);
        }
    }

    /**
     * Fetch and return Article by id or slug.
     *
     * @param string $id Article id or slug.
     * @param string $siteId Site id.
     * @param bool $associated Contain associated articles and images.
     * @return \Cake\ORM\Entity
     * @throws \Cake\Datasource\Exception\RecordNotFoundException
     * @throws \InvalidArgumentException
     */
    public function getArticle($id, $siteId = null, $associated = false)
    {
        if (empty($id)) {
            throw new InvalidArgumentException('Article id or slug cannot be empty.');
        }

        if (!is_string($id)) {
            throw new InvalidArgumentException('Article id or slug must be a string.');
        }

        $contain = [];
        if ($associated) {
            $contain = [
                'Categories',
                'ArticleFeaturedImages'
            ];
        }

        $query = $this->find('all')
            ->limit(1)
            ->where(['Articles.id' => $id])
            ->orWhere(['Articles.slug' => $id])
            ->contain($contain)
            ->applyOptions(['site_id' => $siteId]);

        return $query->firstOrFail();
    }

    /**
     * Fetch and return all Articles, or Articles by site, or Articles by type, or Articles by site and type.
     *
     * @param string $siteId Site id.
     * @param string $type Type name.
     * @param bool $associated Contain associated categories and images.
     * @return \Cake\ORM\Entity
     * @throws \Cake\Datasource\Exception\RecordNotFoundException
     * @throws \InvalidArgumentException
     */
    public function getArticles($siteId, $type, $associated = false)
    {
        if (!is_string($siteId)) {
            throw new InvalidArgumentException('Site id or slug must be a string.');
        }

        if (!is_string($type)) {
            throw new InvalidArgumentException('Article type id or slug must be a string.');
        }

        $contain = [];
        if ((bool)$associated) {
            $contain = [
                'Categories',
                'ArticleFeaturedImages'
            ];
        }

        $conditions = [];
        if ($siteId) {
            $conditions['Articles.site_id'] = $siteId;
        }
        if ($type) {
            $conditions['Articles.type'] = $type;
        }

        $query = $this->find('all')
            ->where($conditions)
            ->contain($contain)
            ->applyOptions(['site_id' => $siteId]);

        return $query->all();
    }

    /**
     * Returns supported types.
     *
     * @param bool $withOptions Flag for including type options
     * @return array
     */
    public function getTypes($withOptions = true)
    {
        if (!empty($this->_types)) {
            return $this->_types;
        }

        $this->_types = Configure::read('CMS.Articles.types');
        ksort($this->_types);
        foreach ($this->_types as $k => &$v) {
            if (!(bool)$v['enabled']) {
                unset($this->_types[$k]);

                continue;
            }

            // normalize field options
            foreach ($v['fields'] as &$field) {
                $field = array_merge($this->_fieldDefaults, $field);
                // normalize options
                if (!empty($field['options'])) {
                    $options = [];
                    foreach ($field['options'] as $index => $option) {
                        $options[Inflector::underscore(Inflector::classify($option))] = $option;
                    }
                    $field['options'] = $options;
                }
            }

            // normalize label
            $v['label'] = $v['label'] ? $v['label'] : Inflector::humanize($k);
        }

        if (!(bool)$withOptions) {
            return array_keys($this->_types);
        }

        return $this->_types;
    }

    /**
     * Returns type options.
     *
     * @param string $type Type name
     * @return array
     */
    public function getTypeOptions($type)
    {
        $result = [];

        $types = $this->getTypes();
        if (!array_key_exists($type, $types)) {
            return $result;
        }

        $result = $types[$type];

        return $result;
    }

    /**
     * Returns specified category(ies) articles.
     *
     * @param array $ids Category(ies) ID(s)
     * @return \Cake\ORM\ResultSet
     */
    public function getArticlesByCategory(array $ids)
    {
        $query = $this->find('all')
            ->where(['Articles.category_id IN' => $ids])
            ->contain(['ArticleFeaturedImages']);

        return $query->all();
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

        $conditions = [$field => $slug];
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
