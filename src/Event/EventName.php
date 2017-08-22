<?php
namespace Cms\Event;

use MyCLabs\Enum\Enum;

/**
 * Event Name enum
 */
class EventName extends Enum
{
    const VIEW_MANAGE_BEFORE_RENDER = 'Cms.View.element.beforeRender';
    const VIEW_TOOLBAR_BEFORE_RENDER = 'Cms.Sites.toolbar.beforeRender';
    const ARTICLES_SHOW_UNPUBLISHED = 'Cms.Articles.showUnpublished';
}
