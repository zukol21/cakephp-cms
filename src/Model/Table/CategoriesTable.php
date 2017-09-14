<?php
namespace Cms\Model\Table;

use Cake\ORM\Entity;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use function GuzzleHttp\Promise\is_fulfilled;
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
    const TREE_SPACER = '&nbsp;&nbsp;&nbsp;&nbsp;';

    /**
     * Categories in a tree list structure, grouped by site.
     *
     * @var array
     */
    protected $_treeList = [];

    /**
     * Categories in a tree list structure, grouped by site.
     *
     * @var array
     */
    protected $_group = [];

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
     * @param string $id Category id or slug.
     * @param \Cake\ORM\Entity $site Site entity.
     * @return \Cake\ORM\Entity
     * @throws \Cake\Datasource\Exception\RecordNotFoundException
     * @throws \InvalidArgumentException
     */
    public function getBySite($id, Entity $site)
    {
        if (empty($id)) {
            throw new InvalidArgumentException('Category id or slug cannot be empty.');
        }

        if (!is_string($id)) {
            throw new InvalidArgumentException('Category id or slug must be a string.');
        }

        $query = $this->find('all')
            ->limit(1)
            ->where(['Categories.id' => $id])
            ->orWhere(['Categories.slug' => $id])
            ->andWhere(['Categories.site_id' => $site->id]);

        return $query->firstOrFail();
    }

    /**
     * Get tree list structure of site's categories.
     *
     * @param string $siteId Site Id.
     * @param string $categoryId Site Id.
     *
     * @return array
     */
    public function getTreeList($siteId = '', $categoryId = '')
    {
        $key = $siteId . $categoryId;

        if (!empty($this->_treeList[$key])) {
            return $this->_treeList[$key];
        }

        $conditions = [];
        if ($siteId) {
            $conditions['Categories.site_id'] = $siteId;
        }
        if ($categoryId) {
            $conditions['Categories.id !='] = $categoryId;
        }

        $this->_treeList[$key] = $this->find('treeList', [
                'conditions' => $conditions,
                'spacer' => static::TREE_SPACER
            ])->toArray();

        return $this->_treeList[$key];
    }

    /**
     * Get tree list structure of site's categories.
     * Category will be added to the tree if there is at least one article under the root categories.
     *
     * @param string $siteId Site Id.
     * @param string $categoryId Site Id.
     *
     * @return array
     */
    public function getTreeListBasedOnArticles($siteId = '', $categoryId = '')
    {
        $key = $siteId . $categoryId;

        if (!empty($this->_treeList[$key])) {
            return $this->_treeList[$key];
        }

        $conditions = [];
        if ($siteId) {
            $conditions['Categories.site_id'] = $siteId;
        }
        if ($categoryId) {
            $conditions['Categories.id !='] = $categoryId;
        }

        //find articles.
        $treeListCopy = $this->find('treeList', [
            'conditions' => $conditions,
            'valuePath' => 'parent_id',
            'spacer' => static::TREE_SPACER
        ])->toArray();

        $articlesTable = TableRegistry::get('Articles');
        foreach ($treeListCopy as $category_id => $value) {
            $treeListCopy[$key][$category_id] = $this->generateCategoryData($articlesTable, $category_id, $value);
        }

        $this->_treeList[$key] = $this->find('treeList', [
            'conditions' => $conditions,
            'spacer' => static::TREE_SPACER
        ])->toArray();

        //debug($this->_treeList[$key]);
        $this->groupCategoriesByParent($treeListCopy[$key]);
        $this->countArticlesUnderCategory(0, $key);

        return $this->_treeList[$key];
    }

    /**
     * Organize the info for a Category
     *
     * @param Table $table articlesTable.
     * @param string $categoryId category ID.
     * @param array $value value.
     * @return array
     */
    protected function generateCategoryData(Table $table, $categoryId, $value)
    {
        $articles = $table->find('all')->where(['category_id' => $categoryId])->toArray();
        $articlesCount = count($articles);

        $parent_id = 0;
        if (!empty($value)) {
            $parent_id = str_replace(static::TREE_SPACER, "", $value);
        }

        $data = [
            'value' => $value,
            'articles' => $articlesCount,
            'category_id' => $categoryId,
            'parent_id' => $parent_id
        ];

        return $data;
    }

    /**
     * Group Categories by Parent Id.
     *
     * @param array $treeList treeList.
     */
    protected function groupCategoriesByParent($treeList)
    {
        foreach ($treeList as $categoryId => $value) {
            $this->_group[$value['parent_id']][] = $value;
        }
    }

    /**
     * Counts the total articles hierarchicaly per level.
     * Removes the categories from _treeList[$treeListKey] that have not any articles.
     *
     * @param int $startKey start key level for the group.
     * @param array $treeListKey treeListKey.
     * @return int
     */
    protected function countArticlesUnderCategory($startKey = 0, $treeListKey = '')
    {
        $levelCount = 0;

        if (empty($this->_group[$startKey])) {
            return $levelCount;
        }

        foreach ($this->_group[$startKey] as $key => $categoryData) {
            $categoryData['articles'] += $this->countArticlesUnderCategory($categoryData['category_id'], $treeListKey);
            $levelCount += $categoryData['articles'];
            $this->_group[$startKey][$key] = $categoryData;

            //Remove Categories that have not Articles
            if (0 === $categoryData['articles']) {
                unset($this->_treeList[$treeListKey][$categoryData['category_id']]);
            }
        }

        return $levelCount;
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
