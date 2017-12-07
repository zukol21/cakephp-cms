<?php
namespace Cms\Test\TestCase\Model\Table;

use Cake\Core\Configure;
use Cake\ORM\Association\BelongsTo;
use Cake\ORM\Association\HasMany;
use Cake\ORM\ResultSet;
use Cake\ORM\RulesChecker;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Cake\Validation\Validator;
use Cms\Model\Entity\Article;
use Cms\Model\Entity\Category;
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
        'plugin.cms.articles',
        'plugin.cms.categories',
        'plugin.cms.sites',
        'plugin.Burzum/FileStorage.file_storage'
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
        $this->assertEquals('articles', $this->Articles->table());

        $this->assertEquals('title', $this->Articles->displayField());
        $this->assertEquals('id', $this->Articles->primaryKey());

        $this->assertTrue($this->Articles->hasBehavior('Timestamp'));
        $this->assertTrue($this->Articles->hasBehavior('Trash'));
        $this->assertTrue($this->Articles->hasBehavior('Slug'));

        $this->assertInstanceOf(HasMany::class, $this->Articles->association('ArticleFeaturedImages'));
        $this->assertInstanceOf(BelongsTo::class, $this->Articles->association('Sites'));
        $this->assertInstanceOf(BelongsTo::class, $this->Articles->association('Categories'));
        $this->assertInstanceOf(BelongsTo::class, $this->Articles->association('Author'));
        $this->assertInstanceOf(BelongsTo::class, $this->Articles->association('Editor'));

        $this->assertInstanceOf(ArticlesTable::class, $this->Articles);
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
            'type' => 'article',
            'excerpt' => '',
            'created_by' => '00000000-0000-0000-0000-000000000001',
            'modified_by' => '00000000-0000-0000-0000-000000000002'
        ];
        $entity = $this->Articles->newEntity();
        $entity = $this->Articles->patchEntity($entity, $data);

        $this->Articles->save($entity);

        $this->assertNotEmpty($entity->id);
        $this->assertEquals('foo-bar', $entity->slug);

        $this->assertInstanceOf(Validator::class, $this->Articles->validationDefault(new Validator()));
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->assertInstanceOf(RulesChecker::class, $this->Articles->buildRules(new RulesChecker()));
    }

    public function testSaveWithShortcode()
    {
        $data = [
            'title' => 'An Article with a Shortcode',
            'content' => 'Some content with a [shortcode]',
            'publish_date' => '2017-04-11 10:00:38',
            'category_id' => '00000000-0000-0000-0000-000000000001',
            'site_id' => '00000000-0000-0000-0000-000000000001',
            'excerpt' => '',
            'created_by' => '162deb54-dc40-4967-b6d2-451c371fdb2d',
            'modified_by' => '63be1f3e-3628-49c7-9f6b-1a7013e154f4',
            'type' => 'article'
        ];

        $entity = $this->Articles->newEntity();
        $entity = $this->Articles->patchEntity($entity, $data);

        $saved = $this->Articles->save($entity);
        $this->assertInstanceOf(Article::class, $saved);
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

    public function testSetSearchQuery()
    {
        $this->assertEquals('', $this->Articles->getSearchQuery());

        $this->Articles->setSearchQuery('foo');
        $this->assertEquals('foo', $this->Articles->getSearchQuery());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testSetSearchQueryWrongParameter()
    {
        $this->Articles->setSearchQuery([]);
    }

    public function testApplySearch()
    {
        $query = $this->Articles->find();
        $expected = clone $query;

        $this->Articles->applySearch($query, 'foo');

        $this->assertNotEquals($expected, $query);
    }

    public function testApplySearchWithoutQuery()
    {
        $query = $this->Articles->find();
        $expected = clone $query;

        $this->Articles->applySearch($query, '');

        $this->assertEquals($expected, $query);
    }

    public function testGetArticle()
    {
        $id = '00000000-0000-0000-0000-000000000001';

        $entity = $this->Articles->getArticle($id);

        $this->assertInstanceOf(Article::class, $entity);
        $this->assertNull($entity->get('category'));
        $this->assertNull($entity->get('article_featured_images'));
    }

    public function testGetArticleWithAssociated()
    {
        $id = '00000000-0000-0000-0000-000000000001';

        $entity = $this->Articles->getArticle($id, null, true);

        $this->assertInstanceOf(Article::class, $entity);
        $this->assertInstanceOf(Category::class, $entity->get('category'));
        $this->assertInternalType('array', $entity->get('article_featured_images'));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testGetArticleEmptyParameter()
    {
        $this->Articles->getArticle('');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testGetArticleWrongParameter()
    {
        $this->Articles->getArticle(['foo']);
    }

    public function testGetArticles()
    {
        $siteId = '00000000-0000-0000-0000-000000000001';
        $type = 'article';

        $entities = $this->Articles->getArticles($siteId, $type);

        $this->assertInstanceOf(ResultSet::class, $entities);
        $this->assertFalse($entities->isEmpty());

        foreach ($entities as $entity) {
            $this->assertInstanceOf(Article::class, $entity);
            $this->assertNull($entity->get('category'));
            $this->assertNull($entity->get('article_featured_images'));
        }
    }

    public function testGetArticlesWithAssociated()
    {
        $siteId = '00000000-0000-0000-0000-000000000001';
        $type = 'article';

        $entities = $this->Articles->getArticles($siteId, $type, true);

        $this->assertInstanceOf(ResultSet::class, $entities);
        $this->assertFalse($entities->isEmpty());

        foreach ($entities as $entity) {
            $this->assertInstanceOf(Article::class, $entity);
            $this->assertInstanceOf(Category::class, $entity->get('category'));
            $this->assertInternalType('array', $entity->get('article_featured_images'));
        }
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testGetArticlesInvalidFirstParameter()
    {
        $this->Articles->getArticles([], '00000000-0000-0000-0000-000000000001');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testGetArticlesInvalidSecondParameter()
    {
        $this->Articles->getArticles('00000000-0000-0000-0000-000000000001', []);
    }

    public function testGetArticlesByCategory()
    {
        $ids = [
            '00000000-0000-0000-0000-000000000001',
            '00000000-0000-0000-0000-000000000002'
        ];

        $entities = $this->Articles->getArticlesByCategory($ids);

        $this->assertInstanceOf(ResultSet::class, $entities);
        $this->assertFalse($entities->isEmpty());

        foreach ($entities as $entity) {
            $this->assertInstanceOf(Article::class, $entity);
        }
    }

    public function testUniqueSlug()
    {
        $data = [
            'title' => 'First Article',
            'excerpt' => 'Lorem ipsum',
            'content' => 'Lorem ipsum dolor sit amet',
            'site_id' => '00000000-0000-0000-0000-000000000001',
            'category_id' => '00000000-0000-0000-0000-000000000001',
            'type' => 'article',
            'publish_date' => '2017-10-05 18:30:00',
            'created_by' => '00000000-0000-0000-0000-000000000001',
            'modified_by' => '00000000-0000-0000-0000-000000000001'
        ];

        $entity = $this->Articles->newEntity();
        $entity = $this->Articles->patchEntity($entity, $data);

        $this->Articles->save($entity);

        $this->assertEquals('first-article-1', $entity->get('slug'));
    }
}
