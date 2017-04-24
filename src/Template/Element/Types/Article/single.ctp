<div class="row">
    <div class="col-md-4 col-lg-3">
        <?= $this->html->image($article->article_featured_images[0]->path, ['class' => 'img-responsive center-block']) ?>
    </div>
    <div class="col-md-8 col-lg-9">
        <?= $article->content ?>
    </div>
</div>