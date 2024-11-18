(function ($) {
    'use strict';

    $(function () {
        fooBar($);
    });
})(jQuery);

function fooBar($) {
    $('.drd-plugin-btn').on('click', function () {
        const urlObj = new URL(window.location.href)
        const postId = urlObj.searchParams.get('post');

        const userData = {
            firstName: jQuery('#first_name').val(),
            lastName: jQuery('#last_name').val(),
            email: jQuery('#email').val(),
            phone: jQuery('#phone_number').val(),
            billing_country: jQuery('#country_billing').val(),
            billing_address_line_1: jQuery('#address_line_1_billing').val(),
            billing_address_line_2: jQuery('#address_line_2_billing').val(),
            billing_city: jQuery('#city_billing').val(),
            billing_postal_code: jQuery('#postal_code_billing').val(),
            shipping_country: jQuery('#country_shipping').val(),
            shipping_address_line_1: jQuery('#address_line_1_shipping').val(),
            shipping_address_line_2: jQuery('#address_line_2_shipping').val(),
            shipping_city: jQuery('#city_shipping').val(),
            shipping_postal_code: jQuery('#postal_code_shipping').val(),
            Sellers_permit: jQuery('#seller039s_permit').val(),
            practitioner_type: jQuery('#practitioner_type').val(),
            title: jQuery('#title').val(),
            website: jQuery('#website').val(),
            tell_us_about_your_practice: jQuery('#tell_us_about_your_practice').val(),
            notes: jQuery('#notes').val()
        }

        $.ajax({
            type: 'POST',
            url: ajax_object.ajax_url,
            data: {
                action: 'foobar',
                nonce: ajax_object.nonce,
                post_id: postId,
                user_data: userData
            },
            success: function (res) {
                console.log(res);
            },
            error: function (xhr, status, error) {
                console.log(error);
            },
        });
    });
}
