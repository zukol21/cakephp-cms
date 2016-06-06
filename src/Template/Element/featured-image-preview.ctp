<div class="modal fade" tabindex="-1" role="dialog" id="featuredImage">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?= __d('cms', 'Preview Image'); ?></h4>
            </div>
            <div class="modal-body">
                <?= $this->Image->display($featuredImage, null, ['class' => 'img-responsive']); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <?= $this->Form->postLink(
                    __d('cms', 'Delete'),
                    [
                        'action' => 'softDeleteFeaturedImage',
                        $featuredImage->id
                    ],
                    [
                        'confirm' => __d('cms', 'Are you sure you want to delete it?'),
                        'title' => __d('cms', 'Delete'),
                        'class' => 'btn btn-danger'
                    ]
                ); ?>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->