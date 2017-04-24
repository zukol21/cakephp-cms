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
                        'categories' => $categories,
                        'article' => $article,
                        'typeOptions' => $articleTypes[$article->type]
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>