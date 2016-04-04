<?php
namespace Cms\Controller;

use Cms\Controller\AppController;

/**
 * Categories Controller
 *
 * @property \Cms\Model\Table\CategoriesTable $Categories
 */
class CategoriesController extends AppController
{
    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $tree = $this->Categories
            ->find('treeList', ['spacer' => self::TREE_SPACER])
            ->toArray();
        $categories = $this->Categories
            ->find('all')
            ->order(['lft' => 'ASC']);
        //Create node property in the entity object
        foreach ($categories as $category) {
            if (in_array($category->id, array_keys($tree))) {
                $category->node = $tree[$category->id];
            }
        }
        $this->set(compact('categories'));
        $this->set('_serialize', ['categories']);
    }

    /**
     * View method
     *
     * @param string|null $id Category id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $category = $this->Categories->get($id, [
            'contain' => ['ParentCategories', 'Articles', 'ChildCategories']
        ]);

        $this->set('category', $category);
        $this->set('_serialize', ['category']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $category = $this->Categories->newEntity();
        if ($this->request->is('post')) {
            $category = $this->Categories->patchEntity($category, $this->request->data);
            if ($this->Categories->save($category)) {
                $this->Flash->success(__('The category has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The category could not be saved. Please, try again.'));
            }
        }
        $list = $this->Categories->find('treeList', ['spacer' => self::TREE_SPACER]);
        $this->set(compact('category', 'list'));
        $this->set('_serialize', ['category']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Category id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $category = $this->Categories->get($id, [
            'contain' => ['Articles']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $category = $this->Categories->patchEntity($category, $this->request->data);
            if ($this->Categories->save($category)) {
                $this->Flash->success(__('The category has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The category could not be saved. Please, try again.'));
            }
        }
        $list = $this->Categories->find('treeList', ['spacer' => self::TREE_SPACER]);
        $this->set(compact('category', 'list'));
        $this->set('_serialize', ['category']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Category id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $category = $this->Categories->get($id);
        if ($this->Categories->delete($category)) {
            $this->Flash->success(__('The category has been deleted.'));
        } else {
            $this->Flash->error(__('The category could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    /**
     * Display method is usually used to populater category templates.
     *
     * @param  string $category Category's slug
     * @return void
     */
    public function display($category = null)
    {
        $this->loadModel('Cms.Articles');
        if (is_null($category)) {
            $this->Flash->error(__d('cms', 'Please provide a category slug.'));
            return $this->redirect('/');
        }

        $category = $this->Categories->findBySlug($category)->first();
        if (!$category) {
            $this->Flash->error(__d('cms', 'The category does not exist.'));
            return $this->redirect('/');
        }
        $children = $this->Categories->find('children', ['for' => $category->id]);
        $articles = $this->Articles->find('ByCategory', ['category' => $category->slug, 'featuredImage' => true]);
        $this->set(compact('articles', 'category', 'children'));
    }

    /**
     * Move up the node.
     *
     * @param  string $id category id
     * @throws InvalidPrimaryKeyException When provided id is invalid.
     * @return void
     */
    public function moveUp($id = null, $number = 1)
    {
        $number = is_numeric($number) ? $number : true;
        $node = $this->Categories->get($id);
        if ($this->Categories->moveUp($node, $number)) {
            $this->Flash->success(__('{0} has been moved up successfully.', $node->name));
        } else {
            $this->Flash->error(__('Fail to move up.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    /**
     * Move down the node.
     *
     * @param  string $id category id
     * @param int|bool $number How many places to move the node or true to move to last position
     * @throws InvalidPrimaryKeyException When provided id is invalid.
     * @return void
     */
    public function moveDown($id = null, $number = 1)
    {
        $number = is_numeric($number) ? $number : true;
        $node = $this->Categories->get($id);
        if ($this->Categories->moveDown($node, $number)) {
            $this->Flash->success(__('{0} has been moved down successfully.', $node->name));
        } else {
            $this->Flash->error(__('Fail to move down.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
