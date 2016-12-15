(function($, ti){
    $(document).ready(function(){
        initAll();
    });

    function initAll(){
        $("#ti_subscribe").on("click", function(e){
            $.ajax({
                url: ajaxurl,
                method: "post",
                data: {
                    "action"        : "ti_subscribe",
                    "nonce"         : $("#ti_subscribe_mail").attr("data-nonce"),
                    "email"         : $("#ti_subscribe_mail").val()
                },
                success: function( data, textStatus, jqXHR ){
                    console.log(data);
                    if(data.data.success){
                        $(".ti-fieldset").hide();
                        $(".ti-subscribe-success").show();
                    }
                }
            });
        });
    }
})(jQuery, ti);