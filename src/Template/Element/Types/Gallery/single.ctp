<?php
$doc = new DOMDocument;
$doc->loadHTML($article->content);
$tags = $doc->getElementsByTagName('img');
$images = [$article->article_featured_images[0]->path];
foreach ($tags as $tag) {
    $images[] = $tag->getAttribute('src');
}
$imgCount = count($images);
?>
<div id="carousel-gallery" class="carousel slide article-type-gallery" data-ride="carousel">
    <ol class="carousel-indicators">
    <?php for ($i = 0; $i < $imgCount; $i++) : ?>
        <li data-target="#carousel-gallery" data-slide-to="<?= $i ?>" class="<?= 0 === $i ? 'active' : '' ?>"></li>
    <?php endfor; ?>
    </ol>
    <div class="carousel-inner">
        <?php for ($i = 0; $i < $imgCount; $i++) : ?>
        <div class="item text-center<?= 0 === $i ? ' active' : '' ?>">
            <?= $this->Html->image($images[$i]) ?>
        </div>
        <?php endfor; ?>
    </div>
    <a class="left carousel-control" href="#carousel-gallery" data-slide="prev">
        <span class="fa fa-angle-left"></span>
    </a>
    <a class="right carousel-control" href="#carousel-gallery" data-slide="next">
        <span class="fa fa-angle-right"></span>
    </a>
</div>
<?= $this->Text->autoParagraph($article->excerpt) ?>