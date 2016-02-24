<?php
namespace Cms\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
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
            ->requirePresence('slug', 'create')
            ->notEmpty('slug')
            ->add('slug', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->requirePresence('excerpt', 'create')
            ->notEmpty('excerpt');

        $validator
            ->requirePresence('content', 'create')
            ->notEmpty('content');

        $validator
            ->requirePresence('featured_img', 'create')
            ->notEmpty('featured_img');

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
}
