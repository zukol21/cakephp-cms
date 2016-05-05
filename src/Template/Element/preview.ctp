<?php if (!empty($slug)) : ?>
    <p class="text-right">
        <?php echo $this->Html->link(
            __d('cms', 'Preview'),
            ['action' => 'display', $slug],
            ['class' => 'btn btn-primary', 'target' => 'blank']
        ); ?>
    </p>
<?php endif ?>