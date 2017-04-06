<?php
use Cake\Utility\Inflector;

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
        placeholder: "-- Please choose --",
        escapeMarkup: function (text) { return text; }
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
// load tinyMCE
echo $this->element('Cms.tinymce');
?>
<section class="content-header">
    <h1><?= __('Create {0}', [Inflector::humanize($this->request->param('pass.1'))]) ?></h1>
</section>
<section class="content">
    <?= $this->Form->create($article, ['type' => 'file']) ?>
    <div class="row">
        <div class="col-lg-4 col-lg-push-8">
            <div class="box box-solid">
                <div class="box-body">
                    <div class="form-group">
                        <div class="required"><?= $this->Form->label(__('Category')); ?></div>
                        <?= $this->Form->select('category_id', $categories, [
                            'class' => 'select2',
                            'required' => true
                        ]); ?>
                    </div>
                    <div class="form-group">
                        <?= $this->Form->input('publish_date', [
                            'type' => 'text',
                            'required' => true,
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
            </div>
        </div>
        <div class="col-lg-8 col-lg-pull-4">
            <div class="box box-solid">
                <div class="box-body">
                <?php foreach ($typeOptions['fields'] as $field => $options) : ?>
                    <?= $this->Form->input($options['field'], [
                        'type' => $options['renderAs'],
                        'required' => (bool)$options['editor'] ? false : (bool)$options['required'],
                        'label' => $field,
                        'class' => (bool)$options['editor'] ? 'tinymce' : ''
                    ]) ?>
                <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <?= $this->Form->button(__('Submit'), ['class' => 'btn-primary']) ?>
    <?= $this->Form->end() ?>
</section>