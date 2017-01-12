(function($){
    $(document).ready(function(){
        $('.themeisle-sdk-subscribe-btn').on('click', function(e){
            var slug = $(this).data('product-slug');
            var email = $('#'+slug+'-themeisle-sdk-email-field');
            $.ajax({
                url: themeisle_sdk.ajax_url,
                method: 'post',
                data: {
                    'action'        : 'themeisle_sdk_subscribe_'+slug,
                    'nonce'         : email.data('nonce'),
                    'email'         : email.val()
                },
                success: function( data, textStatus, jqXHR ){
                    if(data.data.success){
                        $('#'+slug+'-subscribe-box .themeisle-sdk-subscribe-fieldset').hide();
                        $('#'+slug+'-subscribe-box .themeisle-sdk-subscrive-success').show();
                    }
                }
            });
        });
    });
})(jQuery);