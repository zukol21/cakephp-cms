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
        $site = $this->Categories->Sites->getSite($siteId, true);

        $this->set('site', $site);
        $this->set('category', $this->Categories->getBySite($id, $site, true));
        $this->set('categories', $this->Categories->getTreeList($site->id));
        $this->set('article', $this->Categories->Articles->newEntity());
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
        $site = $this->Categories->Sites->getSite($siteId);
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

        $this->set('site', $site);
        $this->set('category', $category);
        $this->set('categories', $this->Categories->getTreeList($site->id));
        $this->set('_serialize', ['category']);
    }

    /**
     * Edit method
     *
     * @param string $siteId Site id or slug.
     * @param string|null $id Category id or slug.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($siteId, $id = null)
    {
        $site = $this->Categories->Sites->getSite($siteId);
        $category = $this->Categories->getBySite($id, $site);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->data;
            $data['site_id'] = $site->id;
            $category = $this->Categories->patchEntity($category, $data);
            if ($this->Categories->save($category)) {
                $this->Flash->success(__('The category has been saved.'));

                return $this->redirect(['controller' => 'Sites', 'action' => 'view', $site->slug]);
            } else {
                $this->Flash->error(__('The category could not be saved. Please, try again.'));
            }
        }

        $this->set('site', $site);
        $this->set('category', $category);
        $this->set('categories', $this->Categories->getTreeList($site->id, $category->id));
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

        $site = $this->Categories->Sites->getSite($siteId);
        $category = $this->Categories->getBySite($id, $site);

        if ($this->Categories->delete($category)) {
            $this->Flash->success(__('The category has been deleted.'));
        } else {
            $this->Flash->error(__('The category could not be deleted. Please, try again.'));
        }

        return $this->redirect(['controller' => 'Sites', 'action' => 'view', $site->slug]);
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

            return $this->redirect($this->referer());
        }

        $site = $this->Categories->Sites->getSite($siteId);
        $category = $this->Categories->getBySite($id, $site);

        $moveFunction = 'move' . $action;
        if ($this->Categories->{$moveFunction}($category)) {
            $this->Flash->success(__('{0} has been moved {1} successfully.', $category->name, $action));
        } else {
            $this->Flash->error(__('Fail to move {0} {1}.', $category->name, $action));
        }

        return $this->redirect($this->referer());
    }
}
