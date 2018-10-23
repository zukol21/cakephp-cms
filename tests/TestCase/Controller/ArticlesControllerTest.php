<?php
namespace Qobo\Cms\Test\TestCase\Controller;

use Cake\ORM\ResultSet;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestCase;
use Qobo\Cms\Model\Entity\Article;
use Qobo\Cms\Model\Entity\Site;

class ArticlesControllerTest extends IntegrationTestCase
{
    public $fixtures = [
        'plugin.qobo/cms.articles',
        'plugin.qobo/cms.categories',
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

        $this->Articles = TableRegistry::get('Qobo/Cms.Articles');

        // Save featured image
        $data = [
            'foreign_key' => '00000000-0000-0000-0000-000000000001',
            'model' => 'ArticleFeaturedImage',
            'filename' => 'cake.icon.png',
        ];
        $table = $this->Articles->ArticleFeaturedImages;
        $entity = $table->newEntity();
        $entity = $table->patchEntity($entity, $data);
        $table->save($entity);
    }

    public function tearDown()
    {
        unset($this->Articles);

        parent::tearDown();
    }

    public function testView()
    {
        $this->get('/cms/site/blog/articles/view/article/first-article');
        $this->assertResponseOk();

        $this->assertInstanceOf(Article::class, $this->viewVariable('article'));
        $this->assertInstanceOf(Site::class, $this->viewVariable('site'));
        $this->assertEquals('article', $this->viewVariable('type'));
        $this->assertInternalType('array', $this->viewVariable('article')->get('article_featured_images'));
        $this->assertInternalType('array', $this->viewVariable('site')->get('categories'));
        $this->assertInternalType('array', $this->viewVariable('categories'));
        $this->assertInternalType('array', $this->viewVariable('filteredCategories'));
    }

    public function testType()
    {
        $this->get('/cms/site/blog/type/article/view');
        $this->assertResponseOk();

        $this->assertInstanceOf(ResultSet::class, $this->viewVariable('articles'));
        $this->assertInstanceOf(Site::class, $this->viewVariable('site'));
        $this->assertEquals('article', $this->viewVariable('type'));
        $this->assertInternalType('array', $this->viewVariable('site')->get('categories'));
        $this->assertInternalType('array', $this->viewVariable('categories'));
        $this->assertInternalType('array', $this->viewVariable('filteredCategories'));
    }

    public function testAdd()
    {
        $data = [
            'title' => 'New Article',
            'content' => 'Some content',
            'excerpt' => 'Some excerpt',
            'publish_date' => '2017-10-06 11:35:00',
            'category_id' => '00000000-0000-0000-0000-000000000001',
            'file' => ['name' => 'test-file.png', 'error' => false]
        ];
        $this->post('/cms/site/blog/articles/add/article', $data);

        $this->assertResponseSuccess();
        $this->assertResponseCode(302);
        $this->assertRedirect('/');
        $this->assertSession('The article has been saved.', 'Flash.flash.0.message');
    }

    public function testAddValidationError()
    {
        $data = [];
        $this->post('/cms/site/blog/articles/add/article', $data);

        $this->assertResponseSuccess();
        $this->assertResponseCode(302);
        $this->assertRedirect('/');
        $this->assertSession('The article could not be saved. Please, try again.', 'Flash.flash.0.message');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testAddInvalidType()
    {
        $this->post('/cms/site/blog/articles/add/foobar');

        $this->assertResponseError();
        $this->assertResponseCode(404);
    }

    /**
     * @dataProvider idsProvider
     */
    public function testEdit($id)
    {
        $data = [
            'title' => 'Modified article title',
            'file' => ['name' => 'test-file.png', 'error' => false]
        ];
        $this->put('/cms/site/blog/articles/edit/article/' . $id, $data);

        $this->assertResponseSuccess();
        $this->assertResponseCode(302);
        $this->assertRedirect('/');
        $this->assertSession('The article has been saved.', 'Flash.flash.0.message');

        $entity = $this->Articles->find()
            ->where(['id' => $id])
            ->orWhere(['slug' => $id])
            ->contain('ArticleFeaturedImages')
            ->first();

        $this->assertEquals($data['title'], $entity->get('title'));
    }

    /**
     * @expectedException InvalidArgumentException
     * @dataProvider idsProvider
     */
    public function testEditInvalidType($id)
    {
        $this->put('/cms/site/blog/articles/edit/foobar/' . $id);

        $this->assertResponseError();
        $this->assertResponseCode(404);
    }

    /**
     * @dataProvider errorsProvider
     */
    public function testEditUploadError($code, $message)
    {
        $data = [
            'title' => 'Modified article title',
            'file' => ['name' => 'test-file.png', 'error' => $code]
        ];
        $this->put('/cms/site/blog/articles/edit/article/first-article', $data);

        $this->assertResponseSuccess();
        $this->assertResponseCode(302);
        $this->assertRedirect('/');

        $this->assertSession($message, 'Flash.flash.0.message');
        if (UPLOAD_ERR_NO_FILE !== $code) {
            $this->assertSession('The article has been saved.', 'Flash.flash.1.message');
        }
    }

    public function testEditNoUploadError()
    {
        $data = [
            'title' => 'Modified article title',
            'file' => ['name' => 'test-file.png', 'error' => UPLOAD_ERR_NO_FILE]
        ];
        $this->put('/cms/site/blog/articles/edit/article/first-article', $data);

        $this->assertResponseSuccess();
        $this->assertResponseCode(302);
        $this->assertRedirect('/');

        $this->assertSession('The article has been saved.', 'Flash.flash.0.message');
    }

    /**
     * @dataProvider idsProvider
     */
    public function testDelete($id)
    {
        $this->delete('/cms/site/blog/articles/delete/' . $id);

        $this->assertResponseSuccess();
        $this->assertResponseCode(302);
        $this->assertRedirect('/');

        $query = $this->Articles->find()->where(['id' => $id]);

        $this->assertTrue($query->isEmpty());
    }

    public function testDeleteInvalidId()
    {
        $id = '00000000-0000-0000-0000-000000000404';
        $this->delete('/cms/site/blog/articles/delete/' . $id);

        $this->assertResponseError();
        $this->assertResponseCode(404);
    }

    public function idsProvider()
    {
        return [
            ['00000000-0000-0000-0000-000000000001'],
            ['first-article']
        ];
    }

    public function errorsProvider()
    {
        return [
            [1, 'The uploaded file exceeds the upload_max_filesize directive in php.ini'],
            [2, 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form'],
            [3, 'The uploaded file was only partially uploaded'],
            [6, 'Missing a temporary folder'],
            [7, 'Failed to write file to disk'],
            [8, 'File upload stopped by extension'],
            [1234, 'Unknown upload error']
        ];
    }
}
