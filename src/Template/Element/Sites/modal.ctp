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
<?php if ($site) : ?>
<div class="modal fade" id="cms-site-edit<?= $site->id ?>" tabindex="-1" role="dialog" aria-labelledby="cms-site-edit<?= $site->id ?>Label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="cms-site-edit<?= $site->id ?>Label">
                    <?= __('Edit') ?> <?= $site->name ?>
                </h4>
            </div>
            <div class="modal-body">
                <?= $this->element('Qobo/Cms.Sites/post', [
                    'url' => [
                        'controller' => 'Sites',
                        'action' => 'edit',
                        $site->id
                    ],
                    'site' => $site,
                ]); ?>
            </div>
        </div>
    </div>
</div>
<?php else : ?>
<div class="modal fade" id="cms-site-add" tabindex="-1" role="dialog" aria-labelledby="cms-site-addLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="cms-site-addLabel">
                    <?= __('Create Site') ?>
                </h4>
            </div>
            <div class="modal-body">
                <?= $this->element('Qobo/Cms.Sites/post', [
                    'url' => [
                        'controller' => 'Sites',
                        'action' => 'add'
                    ],
                    'site' => null,
                ]); ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
