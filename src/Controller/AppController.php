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

        // pass article types to all views
        $this->set('types', $table->getTypes());
    }
}
