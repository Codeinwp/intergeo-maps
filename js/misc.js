(function($, im){
    $(document).on('click', '.intergeo_nag .notice-dismiss', function(e){
        $.ajax({
            url: ajaxurl,
            data: {
                'action'    : im.ajax["action"],
                'security'  : im.ajax["nonce"]
            }
        });
    });
})(jQuery, intergeo_misc)