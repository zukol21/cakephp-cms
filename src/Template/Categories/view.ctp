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

use Cake\Event\Event;
use Cms\Event\EventName;

$this->Breadcrumbs->templates([
    'separator' => '',
]);
$this->Breadcrumbs->add($site->name, [
    'controller' => 'Sites',
    'action' => 'view',
    $site->slug,
]);
$this->Breadcrumbs->add($category->name, null, ['class' => 'active']);
?>
<section class="content-header">
    <h1><?= h($category->name) ?> <small><?= $searchTitle ?></small></h1>
    <?= $this->Breadcrumbs->render(
        ['class' => 'breadcrumb'],
        ['separator' => false]
    ) ?>
</section>
<section class="content">
    <?php
    $element = $this->element('Sites/manage', [
        'articles' => $category->articles,
        'categories' => $categories,
        'site' => $site,
        'article' => null,
        'types' => $types
    ]);
    $event = new Event((string)EventName::VIEW_MANAGE_BEFORE_RENDER(), $this, [
        'menu' => [
            [
                'url' => ['plugin' => 'Cms', 'controller' => 'Sites', 'action' => 'edit', 'pass' => [$site->id]],
                'html' => $element
            ]
        ],
        'user' => $user
    ]);
    $this->eventManager()->dispatch($event);

    echo $event->result;
    ?>
    <div class="row">
        <div class="col-xs-12 col-md-3 col-md-push-9">
            <?= $this->element('Cms.sidebar') ?>
        </div>
        <div class="col-xs-12 col-md-7 col-md-offset-1 col-md-pull-3">
            <?= $this->element('Articles/list', [
                'site' => $site,
                'articles' => $category->articles,
                'articleTypes' => $types
            ]) ?>
        </div>
    </div>
</section>
