<?php
namespace Cms\Event;

use MyCLabs\Enum\Enum;

/**
 * Event Name enum
 */
class EventName extends Enum
{
    const VIEW_MANAGE_BEFORE_RENDER = 'Cms.View.element.beforeRender';
}
