<?php
/**
 * Copyright (c) Qobo Ltd. (https://www.qobo.biz)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Qobo Ltd. (https://www.qobo.biz)
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
namespace Cms\Controller;

use Cms\Controller\AppController;
use Cms\Controller\UploadTrait;
use InvalidArgumentException;

/**
 * Articles Controller
 *
 * @property \Cms\Model\Table\ArticlesTable $Articles
 */
class ArticlesController extends AppController
{
    use UploadTrait;

    /**
     * View method
     *
     * @param string $siteId Site id or slug.
     * @param string $typeId Type slug.
     * @param string|null $id Article id.
     * @return void
     */
    public function view($siteId, $typeId, $id = null)
    {
        $site = $this->Articles->Sites->getSite($siteId, true);

        $this->set('site', $site);
        $this->set('type', $typeId);
        $this->set('article', $this->Articles->getArticle($id, $site->id, true));
        $this->set('categories', $this->Articles->Categories->getTreeList($site->id));
        $this->set('filteredCategories', $this->Articles->Categories->getTreeList($site->id, '', true));
        $this->set('_serialize', ['article']);
    }

    /**
     * Type method
     *
     * @param string $siteId Site id or slug.
     * @param string $typeId Type slug.
     * @return void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function type($siteId, $typeId)
    {
        $site = $this->Articles->Sites->getSite($siteId, true);

        $articles = $this->Articles->getArticles($site->id, $typeId, true);

        $this->set('type', $typeId);
        $this->set('site', $site);
        $this->set('articles', $articles);
        $this->set('categories', $this->Articles->Categories->getTreeList($site->id));
        $this->set('filteredCategories', $this->Articles->Categories->getTreeList($site->id, '', true));
        $this->set('_serialize', ['type']);
    }

    /**
     * Add method
     *
     * @param string $siteId Site id or slug
     * @param string $type Site type
     * @return \Cake\Http\Response
     * @throws \InvalidArgumentException
     */
    public function add($siteId, $type)
    {
        $this->request->allowMethod(['post']);

        $typeOptions = $this->Articles->getTypeOptions($type);

        if (empty($typeOptions)) {
            throw new InvalidArgumentException('Unsupported Article type provided.');
        }

        $site = $this->Articles->Sites->getSite($siteId);

        $data = [
            'site_id' => $site->id,
            'type' => $type,
            'created_by' => $this->Auth->user('id'),
            'modified_by' => $this->Auth->user('id')
        ];
        $data = array_merge($this->request->data, $data);

        $article = $this->Articles->newEntity();
        $article = $this->Articles->patchEntity($article, $data);
        if ($this->Articles->save($article)) {
            $this->Flash->success(__('The article has been saved.'));
            //Upload the featured image when there is one.
            if ($this->_isValidUpload($this->request->data)) {
                $this->_upload($article->get('id'));
            }
        } else {
            $this->Flash->error(__('The article could not be saved. Please, try again.'));
        }

        return $this->redirect($this->referer());
    }

    /**
     * Edit method
     *
     * @param string $siteId Site id or slug.
     * @param string $type Site type.
     * @param string|null $id Article id.
     * @return \Cake\Http\Response
     * @throws \InvalidArgumentException
     */
    public function edit($siteId, $type, $id = null)
    {
        $this->request->allowMethod(['patch', 'post', 'put']);

        $typeOptions = $this->Articles->getTypeOptions($type);

        if (empty($typeOptions)) {
            throw new InvalidArgumentException('Unsupported Article type provided.');
        }

        $site = $this->Articles->Sites->getSite($siteId);

        $data = [
            'site_id' => $site->id,
            'type' => $type,
            'modified_by' => $this->Auth->user('id')
        ];
        $data = array_merge($this->request->data, $data);

        $article = $this->Articles->getArticle($id, $site->id);
        $article = $this->Articles->patchEntity($article, $data);
        if ($this->Articles->save($article)) {
            //Upload the featured image when there is one.
            if ($this->_isValidUpload($this->request->data)) {
                $this->_upload($article->get('id'));
            }
            $this->Flash->success(__('The article has been saved.'));
        } else {
            $this->Flash->error(__('The article could not be saved. Please, try again.'));
        }

        return $this->redirect($this->referer());
    }

    /**
     * Delete method
     *
     * @param string $siteId Site id or slug.
     * @param string|null $id Article id.
     * @return \Cake\Http\Response
     */
    public function delete($siteId, $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        $site = $this->Articles->Sites->getSite($siteId);
        $article = $this->Articles->getArticle($id, $site->id);

        if ($this->Articles->delete($article)) {
            $this->Flash->success(__('The article has been deleted.'));
        } else {
            $this->Flash->error(__('The article could not be deleted. Please, try again.'));
        }

        $redirect = $this->referer();
        if (false !== strpos($redirect, $article->slug)) {
            $redirect = ['controller' => 'Sites', 'action' => 'view', $site->slug];
        }

        return $this->redirect($redirect);
    }

    /**
     * Uploads and stores the related file.
     *
     * @param  int|null $articleId id of the relate slide
     * @return void
     */
    protected function _upload($articleId = null)
    {
        $entity = $this->Articles->ArticleFeaturedImages->newEntity();
        $entity = $this->Articles->ArticleFeaturedImages->patchEntity(
            $entity,
            $this->request->data
        );

        // upload image
        $uploaded = $this->Articles->ArticleFeaturedImages->uploadImage($articleId, $entity);
        if ($uploaded) {
            // delete old image
            $this->Articles->ArticleFeaturedImages->deleteAll([
                'ArticleFeaturedImages.foreign_key' => $articleId,
                'ArticleFeaturedImages.path !=' => $entity->path
            ]);
        }
    }
}
