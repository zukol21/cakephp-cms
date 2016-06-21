<?php
$this->extend('QoboAdminPanel./Common/panel-wrapper');
$this->assign('panel-title', __d('QoboAdminPanel', 'Add new'));
?>
<?= $this->Form->create($category); ?>
<fieldset>
    <?php
    echo $this->Form->input('name');
    echo $this->Form->input('parent_id', ['options' => $list, 'escape' => false]);
    echo $this->Form->input('hide_title');
    ?>
</fieldset>
<?= $this->Form->button(__("Add")); ?>
<?= $this->Form->end() ?>
