<?php
$this->extend('QoboAdminPanel./Common/panel-wrapper');
$this->assign('title', __d('QoboAdminPanel', 'Categories'));
$this->assign('panel-title', __d('QoboAdminPanel', __('Edit {0}', ['Category'])));
?>
<?= $this->Form->create($category); ?>
<fieldset>
    <?php
    echo $this->Form->input('name');
    echo $this->Form->input('slug');
    ?>
</fieldset>
<?= $this->Form->button(__("Save")); ?>
<?= $this->Form->end() ?>
