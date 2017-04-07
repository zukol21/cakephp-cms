<?php
use Cake\Utility\Inflector;

$this->Html->scriptBlock(
    '$(document).on("click", "li.active > a", function() {
        $($(this).parent("li")).removeClass("active");

        // Hides tab contents
        tabName = $(this).attr("href");
        $(tabName).removeClass("active in");
    });',
    ['block' => 'scriptBotton']
);
?>
<div class="box box-solid">
    <div class="box-header">
        <h3 class="box-title"><?= __('Add New') ?>:</h3>
    </div>
    <div class="box-body no-padding">
        <div class="nav-tabs-custom no-margin no-shadow">
            <ul class="nav nav-tabs">
            <?php foreach (array_keys($articleTypes) as $type) : ?>
                <li>
                    <?= $this->Html->link(
                        Inflector::humanize($type),
                        '#' . $type,
                        [
                            'data-toggle' => 'tab',
                            'aria-expanded' => 'true',
                            'style' => 'cursor: auto;'
                        ]
                    ) ?>
                </li>
            <?php endforeach; ?>
            </ul>
            <div class="tab-content">
            <?php foreach (array_keys($articleTypes) as $type) : ?>
                <div role="tabpanel" class="tab-pane fade" id="<?= $type ?>">
                <?= $this->element('Articles/post', [
                    'url' => ['controller' => 'Articles', 'action' => 'add', $site->slug, $type],
                    'article' => $article,
                    'typeOptions' => $articleTypes[$type]
                ]); ?>
                </div>
            <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>