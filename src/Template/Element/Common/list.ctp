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