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
        $category = $this->Categories->getBySite($id, $site);
        $categories = $this->Categories->getTreeList($site->id);

        $categoryIds = [];
        $query = $this->Categories->find('list')->where(['Categories.parent_id' => $category->id]);
        if (!$query->isEmpty()) {
            $categoryIds = array_keys($query->toArray());
        }
        $categoryIds[] = $category->id;

        $articles = $this->Categories->Articles->getArticlesByCategory($categoryIds);
        $category->articles = $articles->toArray();

        $this->set('filteredCategories', $this->Categories->getTreeList($site->id, '', true));
        $this->set(compact('site', 'category', 'categories'));
        $this->set('_serialize', ['category']);
    }

    /**
     * Add method
     *
     * @param string $siteId Site id or slug.
     * @return \Cake\Network\Response
     */
    public function add($siteId)
    {
        $this->request->allowMethod(['post']);

        $site = $this->Categories->Sites->getSite($siteId);
        $category = $this->Categories->newEntity();

        $data = ['site_id' => $site->id];
        $data = array_merge($this->request->data, $data);

        $category = $this->Categories->patchEntity($category, $data);
        if ($this->Categories->save($category)) {
            $this->Flash->success(__('The category has been saved.'));
        } else {
            $this->Flash->error(__('The category could not be saved. Please, try again.'));
        }

        return $this->redirect($this->referer());
    }

    /**
     * Edit method
     *
     * @param string $siteId Site id or slug.
     * @param string|null $id Category id or slug.
     * @return \Cake\Network\Response
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($siteId, $id = null)
    {
        $this->request->allowMethod(['patch', 'post', 'put']);

        $site = $this->Categories->Sites->getSite($siteId);
        $category = $this->Categories->getBySite($id, $site);

        $data = ['site_id' => $site->id];
        $data = array_merge($this->request->data, $data);

        $category = $this->Categories->patchEntity($category, $data);
        if ($this->Categories->save($category)) {
            $this->Flash->success(__('The category has been saved.'));
        } else {
            $this->Flash->error(__('The category could not be saved. Please, try again.'));
        }

         return $this->redirect($this->referer());
    }

    /**
     * Delete method
     *
     * @param string $siteId Site id or slug.
     * @param string|null $id Category id.
     * @return \Cake\Network\Response
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

        $redirect = $this->referer();
        if (false !== strpos($redirect, $category->slug)) {
            $redirect = ['controller' => 'Sites', 'action' => 'view', $site->slug];
        }

        return $this->redirect($redirect);
    }

    /**
     * Move the node.
     *
     * @param string $siteId Site id or slug
     * @param  string $id category id
     * @param  string $action move action
     * @return \Cake\Network\Response
     * @throws InvalidPrimaryKeyException When provided id is invalid.
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
