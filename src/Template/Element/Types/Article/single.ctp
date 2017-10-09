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
<div class="row">
    <div class="col-lg-8 col-lg-offset-2">
        <?= $this->html->image($article->article_featured_images[0]->path, ['class' => 'img-responsive pad center-block']) ?>
    </div>
    <div class="col-xs-12">
        <?= $article->content ?>
    </div>
</div>
