<div class="row">
    <?php foreach ($types[$type]['fields'] as $options) : ?>
    <div class="col-md-6 col-lg-4">
        <?= h($article->{$options['field']}) ?>
    </div>
    <?php endforeach; ?>
</div>