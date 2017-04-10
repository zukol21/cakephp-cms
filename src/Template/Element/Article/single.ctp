<div class="row">
    <div class="col-md-4 col-lg-3">
        <?= $this->html->image($article->article_featured_images[0]->path, [
            'class' => 'img-responsive',
            'style' => 'margin: 0 auto;'
        ]) ?>
    </div>
    <div class="col-md-8 col-lg-9">
        <?= $this->Text->autoParagraph($article->content) ?>
    </div>
</div>