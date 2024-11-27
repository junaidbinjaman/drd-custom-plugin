(function ($) {
    'use strict';

    $(function () {
        fooBar($);

        $('.drd-application-rejection-btn').on('click', function () {
            delete_wp_post($, '', 'post-archive');
        });
    });
})(jQuery);

function fooBar($) {
    $('.drd-application-approval-btn').on('click', function () {
        const urlObj = new URL(window.location.href);
        const postId = urlObj.searchParams.get('post');

        $('.gggg').show();

        const userData = {
            first_name: jQuery('#first_name').val(),
            last_name: jQuery('#last_name').val(),
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
            sellers_permit: jQuery('#seller039s_permit').val(),
            practitioner_type: jQuery('#practitioner_type').val(),
            title: jQuery('#title').val(),
            website: jQuery('#website').val(),
            tell_us_about_your_practice: jQuery(
                '#tell_us_about_your_practice'
            ).val(),
            wholesale_customer_notes: jQuery('#notes').val(),
        };

        $.ajax({
            type: 'POST',
            url: ajax_object.ajax_url,
            data: {
                action: 'foobar',
                nonce: ajax_object.nonce,
                post_id: postId,
                user_data: userData,
            },
            success: function (res) {
                $('.drd-approving-message').hide();
                console.log(res);
                if (res.success) {
                    $('.drd-approved-message').show();
                    setTimeout(() => {
                        delete_wp_post($, res.data.user_id, 'user-page');
                    }, 5000);
                }
            },
            error: function (xhr, status, error) {
                console.log(error);
            },
        });
    });
}

function delete_wp_post($, user_id, redirectTo) {
    const url = new URL(window.location.href);
    const params = new URLSearchParams(url.search);
    const postId = params.get('post');

    $.ajax({
        type: 'POST',
        url: ajax_object.ajax_url,
        data: {
            action: 'delete_wp_post',
            nonce: ajax_object.nonce,
            post_id: postId,
            redirect_to: redirectTo,
        },
        success: function (res) {
            window.location.href = res.data.user_page + user_id;

            console.log(res);
        },
        error: function (xhr, status, error) {
            console.log('HHHHHH');
        },
    });
}
