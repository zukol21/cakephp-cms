<div class="row">
    <div class="col-lg-8 col-lg-offset-2">
        <?= $this->html->image($article->article_featured_images[0]->path, ['class' => 'img-responsive pad center-block']) ?>
    </div>
    <div class="col-xs-12">
        <?= $article->content ?>
    </div>
</div>