<?php
namespace Cms\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Cms\Model\Table\ArticlesTable;

/**
 * Cms\Model\Table\ArticlesTable Test Case
 */
class ArticlesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Cms\Model\Table\ArticlesTable
     */
    public $Articles;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.cms.articles'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Articles') ? [] : ['className' => 'Cms\Model\Table\ArticlesTable'];
        $this->Articles = TableRegistry::get('Articles', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Articles);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        //Table name
        $result = $this->Articles->table();
        $expected = 'articles';
        $this->assertEquals($expected, $result);
        //Display field
        $result = $this->Articles->displayField();
        $expected = 'title';
        $this->assertEquals($expected, $result);
        //Primary key
        $result = $this->Articles->primaryKey();
        $expected = 'id';
        $this->assertEquals($expected, $result);
        //Behaviors
        $behaviors = $this->Articles->behaviors()->loaded();
        $this->assertTrue(in_array('Timestamp', $behaviors));
        $this->assertTrue(in_array('Slug', $behaviors));
        //Associations
        $associations = $this->Articles->associations();
        $result = [];
        foreach ($associations as $assocObj) {
            $result[] = $assocObj->name();
        }
        $this->assertTrue(in_array('ArticleFeaturedImages', $result));
        $this->assertTrue(in_array('Categories', $result));
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
}
