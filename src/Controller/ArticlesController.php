<?php
namespace Cms\Controller;

use Cms\Controller\AppController;

/**
 * Articles Controller
 *
 * @property \Cms\Model\Table\ArticlesTable $Articles
 */
class ArticlesController extends AppController
{
    /**
     * Number of related articles
     */
    const RELATED_LIMIT = 5;

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $query = $this->Articles
            ->find('withLatestImage')
            ->order(['created' => 'DESC']);
        $articles = $this->paginate($query);
        if ($articles->isEmpty()) {
            $this->Flash->set(__('No articles were found. Please add one.'));
            return $this->redirect(['action' => 'add']);
        }
        $this->set(compact('articles'));
        $this->set('_serialize', ['articles']);
    }

    /**
     * View method
     *
     * @param string|null $id Article id.
     * @return void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $article = $this->Articles->find('withLatestImage', ['id' => $id]);
        $categories = [];
        foreach ($article->categories as $category) {
            $categories[] = $category->name;
        }
        $this->set(compact('article', 'categories'));
        $this->set('_serialize', ['article']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $article = $this->Articles->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $article->created_by = $user['username'];
                $article->modified_by = $user['username'];
            }
            $article = $this->Articles->patchEntity($article, $this->request->data);
            if ($this->Articles->save($article)) {
                $this->Flash->success(__('The article has been saved.'));
                //Upload the featured image when there is one.
                if (!$this->request->data['file']['error']) {
                    $this->_upload($article->get('id'));
                }
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The article could not be saved. Please, try again.'));
            }
        }
        $this->set([
            'article' => $article,
            'categories' => $this->Articles->Categories->find('treeList', ['spacer' => self::TREE_SPACER]),
        ]);
        $this->set('_serialize', ['article']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Article id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $article = $this->Articles->find('withLatestImage', ['id' => $id]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $article = $this->Articles->patchEntity($article, $this->request->data);
            if ($this->Articles->save($article)) {
                //Upload the featured image when there is one.
                if (!$this->request->data['file']['error']) {
                    $this->_upload($article->get('id'));
                }
                $this->Flash->success(__('The article has been saved.'));
                return $this->redirect(['action' => 'edit', $article->get('id')]);
            } else {
                $this->Flash->error(__('The article could not be saved. Please, try again.'));
            }
        }
        $this->set([
            'article' => $article,
            'categories' => $this->Articles->Categories->find('treeList', ['spacer' => self::TREE_SPACER]),
        ]);
        $this->set('_serialize', ['article']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Article id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $article = $this->Articles->get($id);
        if ($this->Articles->delete($article)) {
            $this->Flash->success(__('The article has been deleted.'));
        } else {
            $this->Flash->error(__('The article could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    /**
     * Uploads and stores the related file.
     *
     * @param  int|null $articleId id of the relate slide
     * @return boolean           flag
     */
    protected function _upload($articleId = null)
    {
        $entity = $this->Articles->ArticleFeaturedImages->newEntity();
        $entity = $this->Articles->ArticleFeaturedImages->patchEntity(
            $entity,
            $this->request->data
        );

        if ($this->Articles->ArticleFeaturedImages->uploadImage($articleId, $entity)) {
            $this->Flash->set(__('Upload successful'));
            return true;
        }

        return false;
    }

    /**
     * Uploads the files from the CKeditor.
     *
     * @link http://docs.ckeditor.com/#!/guide/dev_file_upload
     * @param  int|null $articleId id of the relate slide
     * @return void
     */
    public function uploadFromEditor($articleId = null)
    {
        $result = [];
        $this->request->is(['ajax']);
        if (!$this->request->data['upload']['error']) {
            $file = ['file' => $this->request->data['upload']];
            $entity = $this->Articles->ContentImages->newEntity();
            $entity = $this->Articles->ContentImages->patchEntity(
                $entity,
                $file
            );
            if ($this->Articles->ContentImages->uploadImage($articleId, $entity)) {
                $result['uploaded'] = 1;
                $result['url'] = $entity->path;
            }
        } else {
            $result['uploaded'] = 0;
            $result['error']['message'] = __d('cms', 'Failed to upload.');
        }
        $this->set('result', $result);
        $this->set('_serialize', 'result');
    }

    /**
     * Display method is usually used to populater category templates.
     *
     * @todo Rendering view file SHOULD be placed in the application.
     * Create a generic view file.
     * @param  string $articleSlug Article's slug
     * @param  int $related Number of related articles
     * @return void
     */
    public function display($articleSlug = null, $related = self::RELATED_LIMIT)
    {
        $article = $this->Articles
            ->findBySlug($articleSlug)
            ->contain($this->Articles->getContain())
            ->first();
        if (!$article) {
            throw new NotFoundException(__('cms', 'Cannot find the article {0}.', $articleSlug));
        }

        $categories = [];
        foreach ($article->categories as $category) {
            array_push($categories, $category->slug);
        }

        $relatedArticles = $this->Articles->find('related', ['categories' => $categories]);
        if (!$relatedArticles->isEmpty()) {
            //Remove shown one and limit the related articles.
            $relatedArticles
                ->where(['Articles.slug <>' => $articleSlug])
                ->limit($related);
        }

        $this->set(compact('article', 'relatedArticles'));
    }
}
