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

echo $this->element('Qobo/Cms.Articles/modal', [
    'site' => $site, 'categories' => $categories, 'types' => $types, 'articles' => $articles
]);

echo $this->element('Qobo/Cms.Categories/modal', [
    'site' => $site, 'categories' => $site->categories, 'categoriesTree' => $categories
]);

echo $this->element('Qobo/Cms.Sites/manage-tabs', [
    'site' => $site, 'categories' => $categories, 'types' => $types, 'article' => $article
]);
?>
<hr />
