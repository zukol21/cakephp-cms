<?php
//Editable entities in the CMS
$editableEntites = ['article', 'category'];
$id = false;
foreach ($editableEntites as $entity) {
    if (isset(${$entity})) {
        $id = ${$entity}->get('id');
    }
}
?>
<?php if ($id) : ?>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-inverse navbar-fixed-bottom">
        <div class="container">
            <ul class="nav navbar-nav">
                <li><?= $this->Html->link(__d('cms', 'Edit Page'), ['action' => 'edit', $id]); ?></li>
            </ul>
        </div>
    </nav>
<?php endif; ?>