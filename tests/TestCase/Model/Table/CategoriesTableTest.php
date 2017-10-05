<?php
namespace Cms\Test\TestCase\Model\Table;

use Cake\ORM\Association\BelongsTo;
use Cake\ORM\Association\HasMany;
use Cake\ORM\RulesChecker;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Cake\Validation\Validator;
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
        $this->assertTrue($this->CategoriesTable->hasBehavior('Timestamp'));
        $this->assertTrue($this->CategoriesTable->hasBehavior('Tree'));
        $this->assertTrue($this->CategoriesTable->hasBehavior('Slug'));
        $this->assertInstanceOf(BelongsTo::class, $this->CategoriesTable->association('Sites'));
        $this->assertInstanceOf(BelongsTo::class, $this->CategoriesTable->association('ParentCategories'));
        $this->assertInstanceOf(HasMany::class, $this->CategoriesTable->association('ChildCategories'));
        $this->assertInstanceOf(HasMany::class, $this->CategoriesTable->association('Articles'));
        $this->assertInstanceOf(CategoriesTable::class, $this->CategoriesTable);
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->assertInstanceOf(Validator::class, $this->CategoriesTable->validationDefault(new Validator()));
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->assertInstanceOf(RulesChecker::class, $this->CategoriesTable->buildRules(new RulesChecker()));
    }

    /**
     * Test getBySite method
     *
     * @return void
     */
    public function testGetBySite()
    {
        $site = $this->CategoriesTable->Sites->getSite('00000000-0000-0000-0000-000000000001');
        $result = $this->CategoriesTable->getBySite('general', $site);
        $this->assertNotEmpty($result);
        $this->assertInternalType('object', $result);
        $this->assertInstanceOf(\Cms\Model\Entity\Category::class, $result);
    }

    /**
     * Test getBySite method
     *
     * @return void
     * @expectedException \InvalidArgumentException
     */
    public function testGetBySiteWithoutId()
    {
        $site = $this->CategoriesTable->Sites->getSite('00000000-0000-0000-0000-000000000001');
        $result = $this->CategoriesTable->getBySite('', $site);
    }

    /**
     * Test getBySite method
     *
     * @expectedException \Cake\Datasource\Exception\RecordNotFoundException
     * @return void
     */
    public function testGetBySiteWithWrongId()
    {
        $site = $this->CategoriesTable->Sites->getSite('00000000-0000-0000-0000-000000000001');
        $result = $this->CategoriesTable->getBySite('non-existing-id', $site);
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
        $entity = $this->CategoriesTable->Sites->getSite('00000000-0000-0000-0000-000000000001');

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
        $entity = $this->CategoriesTable->Sites->getSite('blog');

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
        $entity = $this->CategoriesTable->Sites->getSite(null);
    }

    /**
     * Test getSite method
     *
     * @expectedException \Cake\Datasource\Exception\RecordNotFoundException
     * @return void
     */
    public function testGetSiteWithNonExistingId()
    {
        $entity = $this->CategoriesTable->Sites->getSite('non-existing-id');
    }

    public function testGetTreeList()
    {
        $siteId = '00000000-0000-0000-0000-000000000001';

        $expected = [
            '00000000-0000-0000-0000-000000000001' => 'General',
            '00000000-0000-0000-0000-000000000002' => '&nbsp;&nbsp;&nbsp;&nbsp;News'
        ];

        $this->assertEquals($expected, $this->CategoriesTable->getTreeList($siteId));
    }

    public function testGetTreeListWithCategoryId()
    {
        $siteId = '00000000-0000-0000-0000-000000000001';
        $categoryId = '00000000-0000-0000-0000-000000000001';

        $expected = [
            '00000000-0000-0000-0000-000000000002' => 'News'
        ];

        $this->assertEquals($expected, $this->CategoriesTable->getTreeList($siteId, $categoryId));
    }

    public function testGetTreeListWithArticles()
    {
        $siteId = '00000000-0000-0000-0000-000000000001';

        $expected = [
            '00000000-0000-0000-0000-000000000001' => 'General'
        ];

        $this->assertEquals($expected, $this->CategoriesTable->getTreeList($siteId, '', true));
    }
}
