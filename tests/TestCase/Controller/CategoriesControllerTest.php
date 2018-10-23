<?php
namespace Qobo\Cms\Test\TestCase\Controller;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestCase;
use Qobo\Cms\Model\Entity\Category;
use Qobo\Cms\Model\Entity\Site;

class CategoriesControllerTest extends IntegrationTestCase
{
    public $fixtures = [
        'plugin.qobo/cms.categories',
        'plugin.qobo/cms.articles',
        'plugin.qobo/cms.sites',
        'plugin.Burzum/FileStorage.file_storage'
    ];

    public function setUp()
    {
        parent::setUp();

        $this->session([
            'Auth' => [
                'User' => [
                    'id' => '00000000-0000-0000-0000-000000000001',
                ],
            ],
        ]);

        $this->enableRetainFlashMessages();

        $this->Categories = TableRegistry::get('Qobo/Cms.Categories');

        // Save featured image
        $data = [
            'foreign_key' => '00000000-0000-0000-0000-000000000001',
            'model' => 'ArticleFeaturedImage',
            'filename' => 'cake.icon.png',
        ];
        $table = $this->Categories->Articles->ArticleFeaturedImages;
        $entity = $table->newEntity();
        $entity = $table->patchEntity($entity, $data);
        $table->save($entity);
    }

    public function tearDown()
    {
        unset($this->Categories);

        parent::tearDown();
    }

    public function testView()
    {
        $this->get('/cms/site/blog/category/general/view');
        $this->assertResponseOk();

        $this->assertInstanceOf(Category::class, $this->viewVariable('category'));
        $this->assertInstanceOf(Site::class, $this->viewVariable('site'));
        $this->assertInternalType('array', $this->viewVariable('category')->get('articles'));
        $this->assertInternalType('array', $this->viewVariable('site')->get('categories'));
        $this->assertInternalType('array', $this->viewVariable('categories'));
        $this->assertInternalType('array', $this->viewVariable('filteredCategories'));
    }

    public function testAdd()
    {
        $data = [
            'name' => 'Category 7'
        ];
        $this->post('/cms/site/blog/categories/add', $data);

        $this->assertResponseSuccess();
        $this->assertResponseCode(302);
        $this->assertRedirect('/');
        $this->assertSession('The category has been saved.', 'Flash.flash.0.message');
    }

    public function testAddValidationError()
    {
        $data = [
            // 'name' => 'News',
        ];
        $this->post('/cms/site/blog/categories/add', $data);

        $this->assertResponseSuccess();
        $this->assertResponseCode(302);
        $this->assertRedirect('/');
        $this->assertSession('The category could not be saved. Please, try again.', 'Flash.flash.0.message');
    }

    /**
     * @dataProvider idsProvider
     */
    public function testEdit($id)
    {
        $data = ['name' => 'Category foobar'];
        $this->put('/cms/site/blog/categories/edit/' . $id, $data);

        $this->assertResponseSuccess();
        $this->assertResponseCode(302);
        $this->assertRedirect('/');
        $this->assertSession('The category has been saved.', 'Flash.flash.0.message');

        $entity = $this->Categories->find()
            ->where(['id' => $id])
            ->orWhere(['slug' => $id])
            ->first();
        $this->assertEquals($data['name'], $entity->get('name'));
    }

    /**
     * @dataProvider idsProvider
     */
    public function testDelete($id)
    {
        $this->delete('/cms/site/blog/categories/delete/' . $id);

        $this->assertResponseSuccess();
        $this->assertResponseCode(302);
        $this->assertRedirect('/');

        $query = $this->Categories->find()->where(['id' => $id]);

        $this->assertTrue($query->isEmpty());
    }

    public function testDeleteInvalidId()
    {
        $id = '00000000-0000-0000-0000-000000000404';
        $this->delete('/cms/site/blog/categories/delete/' . $id);

        $this->assertResponseError();
        $this->assertResponseCode(404);
    }

    /**
     * @dataProvider idsProvider
     */
    public function testMoveNode($id, $action)
    {
        $result = $this->Categories->find()
            ->where(['id' => $id])
            ->orWhere(['slug' => $id])
            ->first();

        $this->delete('/cms/site/blog/categories/moveNode/' . $id . '/' . $action);

        $this->assertResponseSuccess();
        $this->assertResponseCode(302);
        $this->assertRedirect('/');

        $entity = $this->Categories->find()
            ->where(['id' => $id])
            ->orWhere(['slug' => $id])
            ->first();

        $this->assertNotEquals($result->get('lft'), $entity->get('lft'));
        $this->assertNotEquals($result->get('rght'), $entity->get('rght'));
    }

    public function testMoveNodeInvalidAction()
    {
        $id = '00000000-0000-0000-0000-000000000001';
        $action = 'foobar';
        $this->delete('/cms/site/blog/categories/moveNode/' . $id . '/' . $action);

        $this->assertResponseSuccess();
        $this->assertResponseCode(302);
        $this->assertRedirect('/');
        $this->assertSession('Unknown move action.', 'Flash.flash.0.message');
    }

    public function idsProvider()
    {
        return [
            ['00000000-0000-0000-0000-000000000001', 'down'],
            ['general', 'down'],
            ['00000000-0000-0000-0000-000000000002', 'up'],
            ['news', 'up']
        ];
    }
}
