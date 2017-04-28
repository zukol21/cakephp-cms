<div class="box box-solid">
    <div class="box-header with-border">
        <i class="fa fa-tag"></i>
        <h3 class="box-title"><?= __('Categories') ?></h3>
    </div>
    <div class="box-body no-padding">
        <ul class="nav nav-stacked">
            <?php foreach ($categories as $category) : ?>
            <li>
                <?= $this->Html->link($category->name, [
                    'controller' => 'Categories',
                    'action' => 'view',
                    $site->slug,
                    $category->slug
                ]) ?>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>