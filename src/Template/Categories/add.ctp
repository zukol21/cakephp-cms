<?php
$this->extend('QoboAdminPanel./Common/panel-wrapper');
$this->assign('title', __d('QoboAdminPanel', 'Categories'));
$this->assign('panel-title', __d('QoboAdminPanel', 'Add new'));
?>
<?= $this->Form->create($category); ?>
<fieldset>
    <legend><?= __('Add {0}', ['Category']) ?></legend>
    <?php
    echo $this->Form->input('slug');
    echo $this->Form->input('name');
    echo $this->Form->input('parent_id', ['options' => $parentCategories]);
    echo $this->Form->input('lft');
    echo $this->Form->input('rght');
    echo $this->Form->input('articles._ids', ['options' => $articles]);
    ?>
</fieldset>
<?= $this->Form->button(__("Add")); ?>
<?= $this->Form->end() ?>
