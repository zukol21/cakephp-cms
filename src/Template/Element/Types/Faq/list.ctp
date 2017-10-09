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

$this->append('article-box-classes', 'collapsed-box');
$this->prepend('article-action-buttons', $this->Html->link('<i class="fa fa-plus"></i>', '#', [
    'class' => 'btn btn-box-tool',
    'data-widget' => 'collapse',
    'escape' => false
]));
$this->append('article-body', $this->Text->truncate($article->content, 200));
