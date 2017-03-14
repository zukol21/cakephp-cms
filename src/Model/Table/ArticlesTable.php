<?php
namespace Cms\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;
use Cms\Model\Table\BaseTable;

/**
 * Articles Model
 *
 */
class ArticlesTable extends BaseTable
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

        $this->table('articles');
        $this->displayField('title');
        $this->primaryKey('id');

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
}
