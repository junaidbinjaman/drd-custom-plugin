(function ($) {
    'use strict';

    $(function () {
        fooBar($);
    });
})(jQuery);

function fooBar($) {
    $('.drd-plugin-btn').on('click', function () {
        $.ajax({
            type: 'POST',
            url: ajax_object.ajax_url,
            data: {
                action: 'foobar',
                nonce: ajax_object.nonce,
            },
            success: function (res) {
                console.log(res);
            },
            error: function (error, xhr, status) {
                console.log(error);
            },
        });
    });
}
