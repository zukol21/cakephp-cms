<?php
namespace Cms\Event\View;

use Cake\Event\Event;
use Cake\Event\EventListenerInterface;

class SitesManageListener implements EventListenerInterface
{
    /**
     * Implemented Events
     *
     * @return array
     */
    public function implementedEvents()
    {
        return [
            'Cms.View.element.beforeRender' => 'sitesManageElement',
        ];
    }

    /**
     * Load sites manage element.
     *
     * @param \Cake\Event\Event $event Event object
     * @param array $menu  Menu
     * @param array $user  User
     * @return void
     */
    public function sitesManageElement(Event $event, array $menu, array $user)
    {
        foreach ($menu as $item) {
            $event->result .= $item['html'];
        }
    }
}
