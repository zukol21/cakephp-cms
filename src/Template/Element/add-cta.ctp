<p class="text-right">
    <?php echo $this->Html->link(
        __d('cms', 'Add New'),
        ['plugin' => $this->request->plugin, 'controller' => $this->request->controller, 'action' => 'add'],
        ['class' => 'btn btn-primary']
    ); ?>
</p>