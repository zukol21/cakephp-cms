(function ($) {
    /**
     * TinyMCE init
     */
    $(document).ready(function () {
        var config = {};
        if ('undefined' !== typeof tinymce_init_config) {
            config = tinymce_init_config;
        }

        config.file_browser_callback = elFinderBrowser;
        tinyMCE.init(config);
    });
})(jQuery);