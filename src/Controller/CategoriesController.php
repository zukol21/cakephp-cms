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
     * View method
     *
     * @param string $siteId Site id or slug.
     * @param string|null $id Category id.
     * @return void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($siteId, $id = null)
    {
        $site = $this->Categories->getSite($siteId, [
            'Categories' => function ($q) {
                return $q->applyOptions(['accessCheck' => false]);
            }
        ]);
        $category = $this->Categories->getCategoryBySite($id, $site, [
            'Sites',
            'Articles' => function ($q) {
                return $q->order(['Articles.publish_date' => 'DESC'])
                    ->contain(['Sites', 'ArticleFeaturedImages'])
                    ->applyOptions(['accessCheck' => false]);
            }
        ]);
        $categories = $this->Categories->find('treeList', [
            'conditions' => ['Categories.site_id' => $site->id],
            'spacer' => self::TREE_SPACER
        ])->applyOptions(['accessCheck' => false]);
        $article = $this->Categories->Articles->newEntity();

        $this->set('site', $site);
        $this->set('category', $category);
        $this->set('categories', $categories);
        $this->set('article', $article);
        $this->set('_serialize', ['category']);
    }

    /**
     * Add method
     *
     * @param string $siteId Site id or slug.
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add($siteId)
    {
        $site = $this->Categories->getSite($siteId);
        $category = $this->Categories->newEntity();

        if ($this->request->is('post')) {
            $data = $this->request->data;
            $data['site_id'] = $site->id;
            $category = $this->Categories->patchEntity($category, $data);
            if ($this->Categories->save($category)) {
                $this->Flash->success(__('The category has been saved.'));

                return $this->redirect(['controller' => 'Sites', 'action' => 'view', $site->id]);
            } else {
                $this->Flash->error(__('The category could not be saved. Please, try again.'));
            }
        }

        $categories = $this->Categories->find('treeList', [
            'conditions' => ['Categories.site_id' => $site->id],
            'spacer' => self::TREE_SPACER
        ]);

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
            $data = $this->request->data;
            $data['site_id'] = $site->id;
            $category = $this->Categories->patchEntity($category, $data);
            if ($this->Categories->save($category)) {
                $this->Flash->success(__('The category has been saved.'));

                return $this->redirect(['controller' => 'Sites', 'action' => 'view', $site->id]);
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

        return $this->redirect(['controller' => 'Sites', 'action' => 'view', $site->id]);
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

            return $this->redirect(['controller' => 'Sites', 'action' => 'view', $siteId]);
        }

        $site = $this->Categories->getSite($siteId);
        $category = $this->Categories->getCategoryBySite($id, $site);

        $moveFunction = 'move' . $action;
        if ($this->Categories->{$moveFunction}($category)) {
            $this->Flash->success(__('{0} has been moved {1} successfully.', $category->name, $action));
        } else {
            $this->Flash->error(__('Fail to move {0} {1}.', $category->name, $action));
        }

        return $this->redirect(['controller' => 'Sites', 'action' => 'view', $site->id]);
    }
}
