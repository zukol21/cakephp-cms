<?php
$formOptions = [];
if (!empty($url)) {
    $formOptions['url'] = $url;
}
?>
<?= $this->Form->create($category, $formOptions) ?>
<div class="box-body">
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
</div>
<div class="box-footer">
    <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>
</div>
<?= $this->Form->end() ?>