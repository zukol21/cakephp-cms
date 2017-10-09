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

$this->start('article-body');
echo $this->fetch('article-body');
echo $this->Html->link(
    $this->Html->image($article->article_featured_images[0]->path, ['class' => 'img-responsive center-block pad']),
    [
        'plugin' => 'Cms',
        'controller' => 'Articles',
        'action' => 'view',
        $site->slug,
        $article->type,
        $article->slug
    ],
    ['escape' => false]
);
echo $this->Html->tag('div', h($article->excerpt), ['class' => 'pad']);
$this->end();
