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

$formOptions = ['type' => 'file'];
if (!empty($url)) {
    $formOptions['url'] = $url;
}
?>
<?= $this->Form->create($article, $formOptions) ?>
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
                        'value' => $article->publish_date ? $article->publish_date->i18nFormat('yyyy-MM-dd HH:mm') : '',
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
            <?php
            foreach ($typeOptions['fields'] as $field => $options) {
                if ('file' === $options['renderAs']) {
                    $hasImage = !empty($article->article_featured_images[0]) ? true : false;
                    if ($hasImage) {
                        $field .= '&nbsp;' . $this->html->image(
                            $article->article_featured_images[0]->path,
                            ['class' => 'img-circle', 'style' => 'height: 20px; width 20px;']
                        );
                    }
                    echo $this->Form->input('file', [
                        'type' => $options['renderAs'],
                        'required' => $hasImage ? false : (bool)$options['required'],
                        'label' => $field,
                        'escape' => false
                    ]);
                } else {
                    echo $this->Form->input($options['field'], [
                        'type' => $options['renderAs'],
                        'required' => (bool)$options['editor'] ? false : (bool)$options['required'],
                        'label' => $field,
                        'class' => (bool)$options['editor'] ? 'tinymce' : ''
                    ]);
                }
            } ?>
            </div>
        </div>
    </div>
</div>
<?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>
<?= $this->Form->end() ?>