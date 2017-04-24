<?php
namespace Cms\Controller;

use Cms\Controller\AppController;

/**
 * Sites Controller
 *
 * @property \Cms\Model\Table\SitesTable $Sites
 */
class SitesController extends AppController
{
    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $sites = $this->Sites->find('all')->all();

        $this->set(compact('sites'));
        $this->set('_serialize', ['sites']);
    }

    /**
     * View method
     *
     * @param string|null $id Site id or slug.
     * @return void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $query = $this->Sites->find('all', [
            'where' => [
                'OR' => [
                    'id' => $id,
                    'slug' => $id
                ]
            ],
            'contain' => [
                'Articles',
                'Categories' => function ($q) {
                    return $q->order(['Categories.lft' => 'ASC']);
                }
            ]
        ]);

        $site = $query->firstOrFail();

        if ($site->categories) {
            $tree = $this->Sites->Categories
                ->find('treeList', ['spacer' => self::TREE_SPACER])
                ->where(['Categories.site_id' => $site->id])
                ->toArray();
            // create node property in the entity object
            foreach ($site->categories as $category) {
                if (!array_key_exists($category->id, $tree)) {
                    continue;
                }
                $category->node = $tree[$category->id];
            }
        }

        $this->set('site', $site);
        $this->set('_serialize', ['site']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $site = $this->Sites->newEntity();
        if ($this->request->is('post')) {
            $site = $this->Sites->patchEntity($site, $this->request->data);
            if ($this->Sites->save($site)) {
                $this->Flash->success(__('The site has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The site could not be saved. Please, try again.'));
        }
        $this->set(compact('site'));
        $this->set('_serialize', ['site']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Site id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $site = $this->Sites->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $site = $this->Sites->patchEntity($site, $this->request->data);
            if ($this->Sites->save($site)) {
                $this->Flash->success(__('The site has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The site could not be saved. Please, try again.'));
        }
        $this->set(compact('site'));
        $this->set('_serialize', ['site']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Site id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $site = $this->Sites->get($id);
        if ($this->Sites->delete($site)) {
            $this->Flash->success(__('The site has been deleted.'));
        } else {
            $this->Flash->error(__('The site could not be deleted. Please, try again.'));
        }

        return $this->redirect($this->referer());
    }
}
