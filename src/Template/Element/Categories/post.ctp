<?php
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