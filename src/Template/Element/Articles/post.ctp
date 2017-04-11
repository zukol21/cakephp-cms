<?php
echo $this->Html->css(
    [
        'AdminLTE./plugins/daterangepicker/daterangepicker-bs3',
        'AdminLTE./plugins/select2/select2.min',
        'Cms.select2-bootstrap.min',
        'Cms.style'
    ],
    [
        'block' => 'css'
    ]
);
echo $this->Html->script(
    [
        'AdminLTE./plugins/daterangepicker/moment.min',
        'AdminLTE./plugins/daterangepicker/daterangepicker',
        'AdminLTE./plugins/select2/select2.full.min',
        'Cms.select2.init',
        'Cms.datetimepicker.init',
    ],
    ['block' => 'scriptBotton']
);

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
                <?= $this->element('Articles/field', [
                    'typeOptions' => $typeOptions,
                    'article' => $article
                ]) ?>
            </div>
        </div>
    </div>
</div>
<?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>
<?= $this->Form->end() ?>