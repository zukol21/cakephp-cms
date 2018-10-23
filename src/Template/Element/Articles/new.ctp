<?php
/**
 * Copyright (c) Qobo Ltd. (https://www.qobo.biz)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Qobo Ltd. (https://www.qobo.biz)
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

$this->Html->scriptBlock(
    '$(document).on("click", "li.active > a", function() {
        $($(this).parent("li")).removeClass("active");

        // Hides tab contents
        tabName = $(this).attr("href");
        $(tabName).removeClass("active in");
    });',
    ['block' => 'scriptBottom']
);
?>
<div class="box box-solid no-shadow">
    <div class="box-body no-padding no-margin">
        <div class="nav-tabs-custom no-margin no-shadow">
            <ul class="nav nav-tabs">
            <?php foreach ($articleTypes as $type => $typeOptions) : ?>
                <li>
                    <?= $this->Html->link(
                        '<i class="fa fa-' . $typeOptions['icon'] . '"></i> ' . $typeOptions['label'],
                        '#' . $type,
                        [
                            'data-toggle' => 'tab',
                            'aria-expanded' => 'true',
                            'style' => 'cursor: auto;',
                            'escape' => false
                        ]
                    ) ?>
                </li>
            <?php endforeach; ?>
            </ul>
            <div class="tab-content">
            <?php foreach (array_keys($articleTypes) as $type) : ?>
                <div role="tabpanel" class="tab-pane fade" id="<?= h($type) ?>">
                <?= $this->element('Qobo/Cms.Articles/post', [
                    'categories' => $categories,
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
