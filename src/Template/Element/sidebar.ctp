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

use Cake\Core\Configure;
?>
<div class="row">
    <div class="col-xs-6 col-md-12">
    <?php
    if (Configure::read('CMS.Sidebar.display.categories')) {
        echo $this->element('Qobo/Cms.Categories/sidebar', [
            'categories' => $site->categories,
            'filteredCategories' => $filteredCategories,
            'site' => $site
        ]);
    }
    ?>
    </div>
    <div class="col-xs-6 col-md-12">
        <?php
        if (Configure::read('CMS.Sidebar.display.types')) {
            echo $this->element('Qobo/Cms.Types/sidebar', ['types' => $types, 'site' => $site]);
        }
        ?>
    </div>
</div>
