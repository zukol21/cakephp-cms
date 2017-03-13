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
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $tree = $this->Categories
            ->find('treeList', ['spacer' => self::TREE_SPACER])
            ->toArray();
        $categories = $this->Categories
            ->find('all')
            ->contain('Sites')
            ->order(['lft' => 'ASC']);
        if ($categories->isEmpty()) {
            $this->Flash->set(__('No categories were found. Please add one.'));

            return $this->redirect(['action' => 'add']);
        }
        //Create node property in the entity object
        foreach ($categories as $category) {
            if (in_array($category->id, array_keys($tree))) {
                $category->node = $tree[$category->id];
            }
        }
        $this->set(compact('categories', 'sites'));
        $this->set('_serialize', ['categories']);
    }

    /**
     * View method
     *
     * @param string $siteId Site id or slug.
     * @param string|null $id Category id.
     * @return void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($siteId, $id = null)
    {
        $site = $this->Categories->getSite($siteId);
        $category = $this->Categories->getCategoryBySite($id, $site, [
            'ParentCategories', 'Articles', 'ChildCategories', 'Sites'
        ]);

        $this->set('category', $category);
        $this->set('_serialize', ['category']);
    }

    /**
     * Add method
     *
     * @param string $siteId Site id or slug.
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     * @throws \InvalidArgumentException
     */
    public function add($siteId)
    {
        $site = $this->Categories->getSite($siteId);
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
        $categories = $this->Categories->find('treeList', [
            'conditions' => ['Categories.site_id' => $site->id],
            'spacer' => self::TREE_SPACER
        ]);
        // $sites = $this->Categories->Sites->find('list')->where(['active' => true]);
        $this->set(compact('category', 'categories', 'site'));
        $this->set('_serialize', ['category']);
    }

    /**
     * Edit method
     *
     * @param string $siteId Site id or slug.
     * @param string|null $id Category id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($siteId, $id = null)
    {
        $site = $this->Categories->getSite($siteId);
        $category = $this->Categories->getCategoryBySite($id, $site);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $category = $this->Categories->patchEntity($category, $this->request->data);
            if ($this->Categories->save($category)) {
                $this->Flash->success(__('The category has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The category could not be saved. Please, try again.'));
            }
        }
        $categories = $this->Categories->find('treeList', [
            'conditions' => ['Categories.site_id' => $site->id, 'Categories.id !=' => $category->id],
            'spacer' => self::TREE_SPACER
        ]);
        $this->set(compact('category', 'categories', 'site'));
        $this->set('_serialize', ['category']);
    }

    /**
     * Delete method
     *
     * @param string $siteId Site id or slug.
     * @param string|null $id Category id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($siteId, $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        $site = $this->Categories->getSite($siteId);
        $category = $this->Categories->getCategoryBySite($id, $site);

        if ($this->Categories->delete($category)) {
            $this->Flash->success(__('The category has been deleted.'));
        } else {
            $this->Flash->error(__('The category could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Move the node.
     *
     * @param string $siteId Site id or slug
     * @param  string $id category id
     * @param  string $action move action
     * @throws InvalidPrimaryKeyException When provided id is invalid.
     * @return \Cake\Network\Response|null
     */
    public function moveNode($siteId, $id = null, $action = '')
    {
        $moveActions = ['up', 'down'];
        if (!in_array($action, $moveActions)) {
            $this->Flash->error(__('Unknown move action.'));

            return $this->redirect(['action' => 'index']);
        }

        $site = $this->Categories->getSite($siteId);
        $category = $this->Categories->getCategoryBySite($id, $site);
        $moveFunction = 'move' . $action;
        if ($this->Categories->{$moveFunction}($category)) {
            $this->Flash->success(__('{0} has been moved {1} successfully.', $category->name, $action));
        } else {
            $this->Flash->error(__('Fail to move {0} {1}.', $category->name, $action));
        }

        return $this->redirect(['action' => 'index']);
    }
}
