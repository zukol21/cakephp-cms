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
?>
<?php foreach ($types[$article->type]['fields'] as $field => $options) : ?>
    <?php
    if (!$article->{$options['field']}) {
        continue;
    } ?>
    <div class="row">
        <div class="col-xs-12 col-md-4">
            <div class="text-right hidden-xs hidden-sm"><strong><?= h($field) ?></strong></div>
            <div class="hidden-md hidden-lg"><strong><?= h($field) ?></strong></div>
        </div>
        <div class="col-xs-12 col-md-8"><?= h($article->{$options['field']}) ?></div>
    </div>
<?php endforeach; ?>
