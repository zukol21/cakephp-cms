<?php
echo $this->Html->css(
    [
        'AdminLTE./plugins/daterangepicker/daterangepicker-bs3',
        'AdminLTE./plugins/select2/select2.min',
        'Cms.select2-bootstrap.min'
    ],
    [
        'block' => 'css'
    ]
);
echo $this->Html->script(
    [
        'AdminLTE./plugins/daterangepicker/moment.min',
        'AdminLTE./plugins/daterangepicker/daterangepicker',
        'AdminLTE./plugins/select2/select2.full.min'
    ],
    ['block' => 'scriptBotton']
);
echo $this->Html->scriptBlock(
    '$(".select2").select2({
        theme: "bootstrap",
        tags: "true",
        placeholder: "-- Please choose --",
        allowClear: true
    });',
    ['block' => 'scriptBotton']
);
echo $this->Html->scriptBlock(
    '$(".datetimepicker").daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        timePicker: true,
        drops: "down",
        timePicker12Hour: false,
        timePickerIncrement: 5,
        format: "YYYY-MM-DD HH:mm"
    });',
    ['block' => 'scriptBotton']
);
$ckeditorId = 'ckeditor' . uniqid();
echo $this->element('Cms.ckeditor', [
    'id' => $ckeditorId,
    'url' => $this->Url->assetUrl(['action' => 'uploadFromEditor', $article->id, '_ext' => 'json'])
]);
?>
<section class="content-header">
    <h1><?= __('Create {0}', ['Article']) ?></h1>
</section>
<section class="content">
    <div class="box box-solid">
        <?= $this->Form->create($article, ['type' => 'file']) ?>
        <div class="box-body">
            <div class="row">
                <div class="col-md-4">
                    <?= $this->Form->input('title') ?>
                </div>
                <div class="col-md-4">
                    <div><?= $this->Form->label(__('Categories')); ?></div>
                    <?= $this->Form->select('categories._ids', $categories, [
                        'class' => 'select2',
                        'multiple' => true
                    ]); ?>
                </div>
                <div class="col-md-4">
                    <?= $this->Form->input('publish_date', [
                        'type' => 'text',
                        'class' => 'datetimepicker',
                        'autocomplete' => 'off',
                        'templates' => [
                            'input' => '<div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="{{type}}" name="{{name}}"{{attrs}}/>
                            </div>'
                        ]
                    ]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <?= $this->Form->input('content', ['type' => 'textarea', 'id' => $ckeditorId]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <?= $this->Form->input('excerpt', ['type' => 'textarea']) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group">
                        <label class="control-label" for="featured-image">
                            <?= __d('cms', 'Featured Image') ?>
                        </label>
                        <?= $this->Form->file('file') ?>
                        <?= $this->Form->error('file') ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-footer">
            <?= $this->Form->button(__('Submit'), ['class' => 'btn-primary']) ?>
        </div>
        <?= $this->Form->end() ?>
    </div>
</section>