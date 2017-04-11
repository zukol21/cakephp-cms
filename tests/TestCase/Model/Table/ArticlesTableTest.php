<?php
namespace Cms\Test\TestCase\Model\Table;

use Cake\Core\Configure;
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

        // load default plugin config
        Configure::load('Cms.cms');
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
        $data = [
            'title' => 'Foo bar',
            'content' => 'Lorem ipsum...',
            'category_id' => '00000000-0000-0000-0000-000000000001',
            'publish_date' => '2017-04-11 10:00:38',
            'site_id' => '00000000-0000-0000-0000-000000000001',
            'type' => 'foo',
            'excerpt' => '',
            'created_by' => '00000000-0000-0000-0000-000000000001',
            'modified_by' => '00000000-0000-0000-0000-000000000002'
        ];
        $entity = $this->Articles->newEntity();
        $entity = $this->Articles->patchEntity($entity, $data);

        $this->Articles->save($entity);

        $this->assertNotEmpty($entity->id);
        $this->assertEquals('foo-bar', $entity->slug);
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

    public function testGetTypes()
    {
        $result = $this->Articles->getTypes();

        $this->assertNotEmpty($result);
        $this->assertInternalType('array', $result);
        $this->assertArrayHasKey('article', $result);
    }

    public function testGetTypesDoubleCall()
    {
        $this->Articles->getTypes();
        $result = $this->Articles->getTypes();

        $this->assertNotEmpty($result);
        $this->assertInternalType('array', $result);
        $this->assertArrayHasKey('article', $result);
    }

    public function testGetTypesWithDisabledType()
    {
        Configure::write('CMS.Articles.types.article.enabled', false);
        $result = $this->Articles->getTypes();

        $this->assertArrayNotHasKey('article', $result);
    }

    public function testGetTypesWithoutOptions()
    {
        $result = $this->Articles->getTypes(false);

        $this->assertNotEmpty($result);
        $this->assertInternalType('array', $result);
        $this->assertContains('article', $result);
    }

    public function testGetOptions()
    {
        $result = $this->Articles->getTypeOptions('article');

        $this->assertNotEmpty($result);
        $this->assertInternalType('array', $result);
        $this->assertArrayHasKey('fields', $result);
    }

    public function testGetOptionsWithWrongType()
    {
        $result = $this->Articles->getTypeOptions('foobar');

        $this->assertEmpty($result);
    }
}
