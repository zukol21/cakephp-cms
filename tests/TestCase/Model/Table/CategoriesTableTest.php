<?php
namespace Cms\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Cms\Model\Table\CategoriesTable;

/**
 * Cms\Model\Table\CategoriesTable Test Case
 */
class CategoriesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Cms\Model\Table\CategoriesTable
     */
    public $CategoriesTable;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.cms.categories',
        'plugin.cms.sites',
        'plugin.cms.articles',
        'plugin.cms.article_featured_images',
        'plugin.cms.author',
        'plugin.cms.social_accounts',
        'plugin.cms.users',
        'plugin.cms.editor'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Categories') ? [] : ['className' => 'Cms\Model\Table\CategoriesTable'];
        $this->CategoriesTable = TableRegistry::get('Categories', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CategoriesTable);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test getCategoryBySite method
     *
     * @return void
     */
    public function testGetCategoryBySite()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
