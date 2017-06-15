<?php
namespace Cms\Controller;

use App\Controller\AppController as BaseController;
use Cake\Event\Event;
use Cms\Model\Table\ArticlesTable;

class AppController extends BaseController
{
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
    }

    /**
     * {@inheritDoc}
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        $table = $this->{$this->name};
        $table = $table->association('Articles') ? $this->{$this->name}->Articles->target() : $table;

        if (!$table instanceof ArticlesTable) {
            return;
        }

        // pass article types to all Views
        $this->set('types', $table->getTypes());

        $searchQuery = $this->request->query('q') ?: '';

        $searchTitle = $searchQuery ? __('Search Results for') . ' \'' . $searchQuery . '\'' : '';
        // pass search title to all Views
        $this->set('searchTitle', $searchTitle);

        // set search query on Articles table
        $table->setSearchQuery($searchQuery);
    }
}
