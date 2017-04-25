<?php
use Cake\Event\Event;

$menu = [];

// broadcast menu event
$event = new Event('Cms.View.topMenu.beforeRender', $this, [
    'menu' => $menu,
    'user' => $user
]);
$this->eventManager()->dispatch($event);

echo $event->result;
