<?php
$this->extend('QoboAdminPanel./Common/panel-wrapper');
$this->assign('panel-title', __d('Cms', __('Add {0}', ['Category'])));
?>
<?= $this->Form->create($category); ?>
<fieldset>
    <?php
    echo $this->Form->input('slug');
    echo $this->Form->input('name');
    ?>
</fieldset>
<?= $this->Form->button(__("Add")); ?>
<?= $this->Form->end() ?>
