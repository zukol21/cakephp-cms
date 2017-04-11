(function ($) {
    var $grid = $('.masonry-container').imagesLoaded( function() {
        // init Masonry after all images have loaded
        $grid.masonry({
            columnWidth: '.item',
            itemSelector: '.item',
            percentPosition: true
        });
    });
})(jQuery);