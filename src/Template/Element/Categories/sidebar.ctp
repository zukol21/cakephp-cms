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
?>
<div class="box box-solid">
    <div class="box-header with-border">
        <i class="fa fa-tag"></i>
        <h3 class="box-title"><?= __('Categories') ?></h3>
    </div>
    <div class="box-body no-padding">
        <ul class="nav nav-stacked">
            <?php foreach ($categories as $category) :
                if (!array_key_exists($category->id, $filteredCategories)) {
                    continue;
                }?>
                <li>
                    <?= $this->Html->link(
                        $category->node,
                        ['controller' => 'Categories', 'action' => 'view', $site->slug, $category->slug],
                        ['escape' => false]
                    ) ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
