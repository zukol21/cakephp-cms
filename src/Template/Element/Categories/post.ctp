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

$formOptions = [];
if (!empty($url)) {
    $formOptions['url'] = $url;
}
?>
<?= $this->Form->create($category, $formOptions) ?>
    <div class="row">
        <div class="col-md-6">
            <?= $this->Form->input('name') ?>
        </div>
        <div class="col-md-6">
            <?= $this->Form->input('parent_id', [
                'options' => $categories,
                'escape' => false,
                'empty' => true
            ]) ?>
        </div>
    </div>
    <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>
<?= $this->Form->end() ?>
