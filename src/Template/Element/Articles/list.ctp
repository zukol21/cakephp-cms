<?php
use Cake\Utility\Inflector;

echo $this->Html->script([
    'Cms./plugins/masonry/masonry.pkgd.min',
    'Cms./plugins/imagesloaded/imagesloaded.pkgd.min',
    'Cms.masonry.init'
], ['block' => 'scriptBotton']);

$elements = [];
foreach ($articles as $article) {
    $element = 'Plugin/Cms/' . Inflector::camelize($article->type) . '/list';

    // fallback to plugin's element
    if (!$this->elementExists($element)) {
        $element = Inflector::camelize($article->type) . '/list';
    }

    // fallback to default element
    if (!$this->elementExists($element)) {
        $element = 'Common/list';
    }

    $elements[] = [
        'name' => $element,
        'data' => [
            'types' => $types,
            'article' => $article
        ]
    ];
}
?>
<div class ="row masonry-container">
<?php foreach ($elements as $element) : ?>
    <div class="col-xs-12 col-md-6 col-lg-4 item">
        <div class="box box-solid">
            <div class="box-header with-border">
                <i class="fa fa-<?= $types[$element['data']['article']->type]['icon'] ?> text-muted"></i>
                <h3 class="box-title">
                <?= $this->Html->link(
                    $this->Text->truncate($element['data']['article']->title, 35, ['exact' => false]),
                    [
                        'controller' => 'Articles',
                        'action' => 'view',
                        $element['data']['article']->site->slug,
                        $element['data']['article']->type,
                        $element['data']['article']->slug
                    ],
                    ['title' => h($element['data']['article']->title)]
                ) ?></h3>
                <div class="box-tools pull-right">
                    <?= $this->Html->link('<i class="fa fa-pencil"></i>', '#', [
                        'title' => __('Edit'),
                        'class' => 'btn btn-box-tool',
                        'escape' => false,
                        'data-toggle' => 'modal',
                        'data-target' => '#' . $element['data']['article']->slug
                    ]) ?>
                    <?= $this->Form->postLink(
                        '<i class="fa fa-trash"></i>',
                        [
                            'controller' => 'Articles',
                            'action' => 'delete',
                            $element['data']['article']->site->slug,
                            $element['data']['article']->slug
                        ],
                        [
                            'confirm' => __('Are you sure you want to delete # {0}?', $element['data']['article']->title),
                            'title' => __('Delete'),
                            'class' => 'btn btn-box-tool',
                            'escape' => false
                        ]
                    ) ?>
                </div>
            </div>
            <div class="box-body">
                <?= $this->element($element['name'], $element['data']); ?>
            </div>
            <div class="box-footer small">
                <div class="text-muted text-right">
                <?php
                if ('type' === $this->request->action) {
                    $assocUrl = $this->Html->link($element['data']['article']->category->name, [
                        'controller' => 'Categories',
                        'action' => 'view',
                        $element['data']['article']->site->slug,
                        $element['data']['article']->category->slug
                    ]);
                } else {
                    $assocUrl = $this->Html->link($types[$element['data']['article']->type]['label'], [
                        'controller' => 'Articles',
                        'action' => 'type',
                        $element['data']['article']->site->slug,
                        $element['data']['article']->type
                    ]);
                }
                ?>
                <?= $assocUrl ?>
                |
                <?= __('Published') ?>
                <?= $element['data']['article']->publish_date->timeAgoInWords([
                    'format' => 'MMM d, YYY',
                    'end' => '1 month'
                ]) ?>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
</div>
<?php foreach ($articles as $article) : ?>
    <div class="modal fade" id="<?= $article->slug ?>" tabindex="-1" role="dialog" aria-labelledby="<?= $article->slug ?>Label">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="<?= $article->slug ?>Label">
                        <?= __('Edit') ?> <?= $article->title ?>
                    </h4>
                </div>
                <div class="modal-body">
                    <?= $this->element('Articles/post', [
                        'url' => [
                            'controller' => 'Articles',
                            'action' => 'edit',
                            $article->site->slug,
                            $article->type,
                            $article->slug
                        ],
                        'article' => $article,
                        'typeOptions' => $articleTypes[$article->type]
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>