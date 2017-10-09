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
namespace Cms\Event\View;

use Cake\Event\Event;
use Cake\Event\EventListenerInterface;
use Cms\Event\EventName;

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
            (string)EventName::VIEW_MANAGE_BEFORE_RENDER() => 'sitesManageElement',
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
