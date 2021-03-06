( function ($) {
    $.extend($.summernote.plugins, {
        /**
         * @param {Object} context - context object has status of editor.
         */
        'rkeventphotosmodule': function (context) {
            var self = this;

            // ui provides methods to build ui elements.
            var ui = $.summernote.ui;

            // add button
            context.memo('button.rkeventphotosmodule', function () {
                // create button
                var button = ui.button({
                    contents: '<img src="' + Zikula.Config.baseURL + Zikula.Config.baseURI + '/web/modules/rkeventphotos/images/admin.png' + '" alt="Event photos" width="16" height="16" />',
                    tooltip: 'Event photos',
                    click: function () {
                        RKEventPhotosModuleFinderOpenPopup(context, 'summernote');
                    }
                });

                // create jQuery object from button instance.
                var $button = button.render();

                return $button;
            });
        }
    });
})(jQuery);
