<?php
echo $this->Html->css('AdminLTE./plugins/iCheck/all', ['block' => 'css']);
echo $this->Html->script('AdminLTE./plugins/iCheck/icheck.min', ['block' => 'scriptBotton']);
echo $this->Html->scriptBlock(
    '$(\'input[type="checkbox"].square, input[type="radio"].square\').iCheck({
        checkboxClass: \'icheckbox_square\',
        radioClass: \'iradio_square\'
    });',
    ['block' => 'scriptBotton']
);
?>
<section class="content-header">
    <h1><?= __('Create {0}', ['Category']) ?></h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <div class="box box-solid">
                <?= $this->Form->create($category); ?>
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
        </div>
    </div>
</section>