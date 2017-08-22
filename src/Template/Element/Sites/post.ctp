<?php
echo $this->Html->css('AdminLTE./plugins/iCheck/all', ['block' => 'css']);
echo $this->Html->script([
    'AdminLTE./plugins/iCheck/icheck.min',
    'Cms.icheck.init'
    ], ['block' => 'scriptBottom']);

$formOptions = [];
if (!empty($url)) {
    $formOptions['url'] = $url;
}

$checked = $site ? $site->active : true;
?>
<?= $this->Form->create($site, $formOptions); ?>
    <div class="row">
        <div class="col-md-6">
            <?= $this->Form->input('name') ?>
        </div>
        <div class="col-md-6">
            <?php
            $label = $this->Form->label('active');
            echo $this->Form->input('active', [
                'type' => 'checkbox',
                'checked' => $checked,
                'class' => 'square',
                'label' => false,
                'templates' => [
                    'inputContainer' => '<div class="{{required}}">' . $label . '<div class="clearfix"></div>{{content}}</div>'
                ]
            ]);
            ?>
        </div>
    </div>
    <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>
<?= $this->Form->end() ?>