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
<?php foreach ($categories as $category) : ?>
    <div class="modal fade" id="<?= $category->id ?>" tabindex="-1" role="dialog" aria-labelledby="<?= $category->id ?>Label">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="<?= $category->id ?>Label">
                        <?= __('Edit') ?> <?= $category->name ?>
                    </h4>
                </div>
                <div class="modal-body">
                    <?= $this->element('Categories/post', [
                        'url' => [
                            'controller' => 'Categories',
                            'action' => 'edit',
                            $site->slug,
                            $category->slug
                        ],
                        'category' => $category,
                        'categories' => $categoriesTree
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
<div class="modal fade" id="add-new-category" tabindex="-1" role="dialog" aria-labelledby="add-new-categoryLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="add-new-categoryLabel">
                    <?= __('Create Category') ?>
                </h4>
            </div>
            <div class="modal-body">
                <?= $this->element('Categories/post', [
                    'url' => [
                        'controller' => 'Categories',
                        'action' => 'add',
                        $site->slug
                    ],
                    'category' => null,
                    'categories' => $categoriesTree
                ]); ?>
            </div>
        </div>
    </div>
</div>
