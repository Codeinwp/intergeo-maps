/* global ajaxurl */
/* global intergeo_misc */
(function ($, im) {
    $(document).on('click', '.intergeo_nag .notice-dismiss', function () {
        $.ajax({
            url: ajaxurl,
            data: {
                'action': im.ajax.action,
                'security': im.ajax.nonce
            }
        });
    });

    $(document).on('click', '.themeisle_triggered_feedback_nag .notice-dismiss', function () {
        themeisle_dismiss_feedback_nag();
    });

    $(document).on('click', '.themeisle-feedback-click', function () {

        themeisle_dismiss_feedback_nag();
        $('.themeisle_triggered_feedback_nag').remove();
    });

    function themeisle_dismiss_feedback_nag() {
        $.ajax({
            url: ajaxurl,
            data: {
                'action': im.ajax.themeisle_feedback_action,
                'slug': im.ajax.themeisle_feedback_slug,
                'security': im.ajax.nonce
            }
        });
    }

})(jQuery, intergeo_misc);