<?php
namespace Cms\Test\TestCase\Controller;

use Cake\ORM\ResultSet;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestCase;
use Cms\Controller\SitesController;
use Cms\Model\Entity\Site;

class SitesControllerTest extends IntegrationTestCase
{
    public $fixtures = [
        'plugin.cms.sites',
        'plugin.cms.articles',
        'plugin.cms.categories',
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

        $this->Sites = TableRegistry::get('Cms.Sites');

        // Save featured image
        $data = [
            'foreign_key' => '00000000-0000-0000-0000-000000000001',
            'model' => 'ArticleFeaturedImage',
            'filename' => 'cake.icon.png',
        ];
        $table = $this->Sites->Articles->ArticleFeaturedImages;
        $entity = $table->newEntity();
        $entity = $table->patchEntity($entity, $data);
        $table->save($entity);
    }

    public function tearDown()
    {
        unset($this->Sites);

        parent::tearDown();
    }

    public function testIndex()
    {
        $this->get('/cms/sites');
        $this->assertResponseOk();

        $this->assertInstanceOf(ResultSet::class, $this->viewVariable('sites'));
    }

    public function testView()
    {
        $this->get('/cms/sites/view/blog');
        $this->assertResponseOk();

        $this->assertInstanceOf(Site::class, $this->viewVariable('site'));
        $this->assertInternalType('array', $this->viewVariable('site')->get('articles'));
        $this->assertInternalType('array', $this->viewVariable('site')->get('categories'));
        $this->assertInternalType('array', $this->viewVariable('categories'));
        $this->assertInternalType('array', $this->viewVariable('filteredCategories'));
    }

    public function testAdd()
    {
        $data = [
            'name' => 'News',
            'active' => true,
        ];
        $this->post('/cms/sites/add', $data);

        $this->assertResponseSuccess();
        $this->assertResponseCode(302);
        $this->assertRedirect('/cms/sites/view/news');
        $this->assertSession('The site has been saved.', 'Flash.flash.0.message');
    }

    public function testAddValidationError()
    {
        $data = [
            'name' => 'News',
            // 'active' => true,
        ];
        $this->post('/cms/sites/add', $data);

        $this->assertResponseSuccess();
        $this->assertResponseCode(302);
        $this->assertRedirect('/cms/sites');
        $this->assertSession('The site could not be saved. Please, try again.', 'Flash.flash.0.message');
    }

    public function testEdit()
    {
        $id = '00000000-0000-0000-0000-000000000001';
        $data = ['name' => 'Foobar'];
        $this->put('/cms/sites/edit/' . $id, $data);

        $this->assertResponseSuccess();
        $this->assertResponseCode(302);
        $this->assertRedirect('/cms/sites/view/blog');
        $this->assertSession('The site has been saved.', 'Flash.flash.0.message');

        $entity = $this->Sites->get($id);
        $this->assertEquals($data['name'], $entity->get('name'));
    }

    public function testDelete()
    {
        $id = '00000000-0000-0000-0000-000000000001';
        $this->delete('/cms/sites/delete/' . $id);

        $this->assertResponseSuccess();
        $this->assertResponseCode(302);
        $this->assertRedirect('/cms/sites');

        $query = $this->Sites->find()->where(['id' => $id]);

        $this->assertTrue($query->isEmpty());
    }

    public function testDeleteInvalidId()
    {
        $id = '00000000-0000-0000-0000-000000000404';
        $this->delete('/cms/sites/delete/' . $id);

        $this->assertResponseError();
        $this->assertResponseCode(404);
    }
}
