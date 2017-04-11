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
        'plugin.cms.users',
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
        $site = $this->CategoriesTable->getSite('00000000-0000-0000-0000-000000000001');
        $result = $this->CategoriesTable->getCategoryBySite('general', $site);
        $this->assertNotEmpty($result);
        $this->assertInternalType('object', $result);
        $this->assertInstanceOf(\Cms\Model\Entity\Category::class, $result);
    }

    /**
     * Test getCategoryBySite method
     *
     * @return void
     * @expectedException \InvalidArgumentException
     */
    public function testGetCategoryBySiteWithoutId()
    {
        $site = $this->CategoriesTable->getSite('00000000-0000-0000-0000-000000000001');
        $result = $this->CategoriesTable->getCategoryBySite('', $site);
    }

    /**
     * Test getCategoryBySite method
     *
     * @expectedException \Cake\Datasource\Exception\RecordNotFoundException
     * @return void
     */
    public function testGetCategoryBySiteWithWrongId()
    {
        $site = $this->CategoriesTable->getSite('00000000-0000-0000-0000-000000000001');
        $result = $this->CategoriesTable->getCategoryBySite('non-existing-id', $site);
    }

    /**
     * Test _uniqueSlug method
     *
     * @return void
     */
    public function testUniqueSlug()
    {
        $data = ['name' => 'Foo bar', 'site_id' => '00000000-0000-0000-0000-000000000001'];
        $entity = $this->CategoriesTable->newEntity();
        $entity = $this->CategoriesTable->patchEntity($entity, $data);

        $this->CategoriesTable->save($entity);
        $this->assertEquals('foo-bar', $entity->slug);


        $anotherEntity = $this->CategoriesTable->newEntity();
        $anotherEntity = $this->CategoriesTable->patchEntity($anotherEntity, $data);
        $this->CategoriesTable->save($anotherEntity);
        $this->assertEquals('foo-bar-1', $anotherEntity->slug);
    }

    /**
     * Test getSite method
     *
     * @return void
     */
    public function testGetSiteById()
    {
        $entity = $this->CategoriesTable->getSite('00000000-0000-0000-0000-000000000001');

        $this->assertInstanceOf(\Cake\ORM\Entity::class, $entity);
        $this->assertNotEmpty($entity->id);
    }

    /**
     * Test getSite method
     *
     * @return void
     */
    public function testGetSiteBySlug()
    {
        $entity = $this->CategoriesTable->getSite('blog');

        $this->assertInstanceOf(\Cake\ORM\Entity::class, $entity);
        $this->assertNotEmpty($entity->slug);
    }

    /**
     * Test getSite method
     *
     * @expectedException \InvalidArgumentException
     * @return void
     */
    public function testGetSiteWithoutId()
    {
        $entity = $this->CategoriesTable->getSite(null);
    }

    /**
     * Test getSite method
     *
     * @expectedException \Cake\Datasource\Exception\RecordNotFoundException
     * @return void
     */
    public function testGetSiteWithNonExistingId()
    {
        $entity = $this->CategoriesTable->getSite('non-existing-id');
    }
}
