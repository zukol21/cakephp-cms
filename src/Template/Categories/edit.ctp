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
    <h1><?= __('Edit {0}', ['Category']) ?></h1>
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
                                'options' => $list,
                                'escape' => false,
                                'empty' => true
                            ]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $this->Form->input('site_id') ?>
                        </div>
                        <div class="col-md-6">
                            <?= $this->Form->input('align_category_article_image', [
                                'options' => $category->get('align_options')
                            ]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                        <?php
                            $label = $this->Form->label('hide_title');
                            echo $this->Form->input('hide_title', [
                                'type' => 'checkbox',
                                'class' => 'square',
                                'label' => false,
                                'templates' => [
                                    'inputContainer' => '<div class="{{required}}">' . $label . '<div class="clearfix"></div>{{content}}</div>'
                                ]
                            ]);
                        ?>
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