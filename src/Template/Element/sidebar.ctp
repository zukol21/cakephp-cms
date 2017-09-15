<?php use Cake\Core\Configure; ?>
<div class="row">
    <div class="col-xs-6 col-md-12">
    <?php
    if (Configure::read('CMS.Sidebar.display.categories')) {
        echo $this->element('Categories/sidebar', [
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
            echo $this->element('Types/sidebar', ['types' => $types, 'site' => $site]);
        }
        ?>
    </div>
</div>