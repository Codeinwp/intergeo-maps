<?php

add_action("wp_ajax_ti_subscribe", "themeisle_subscribe");
//add_filter("themeisle_subscribed_msg", "themeisle_subscribed_msg");
//add_filter("themeisle_subscribe_msg", "themeisle_subscribe_msg");
//add_filter("themeisle_subscribe_heading", "themeisle_subscribe_heading");

function themeisle_subscribe() {
    check_ajax_referer("themeisle_subscribe", "nonce");

    $email  = $_POST["email"];
    if(!empty($email)){
        require_once ( dirname(__FILE__) . '/mailin.php' );
        $user_info  = get_userdata(1);
        $mailin     = new Mailin("https://api.sendinblue.com/v2.0","cHW5sxZnzE7mhaYb");
        $data       = array(
                        "email" => $email,
                        "attributes" => array("NAME"=>$user_info->first_name, "SURNAME"=>$user_info->last_name),
                        "blacklisted" => 0,
                        "listid" => array(51),
                        "blacklisted_sms" => 0
        );
        $status =  $mailin->create_update_user($data);
        if($status['code'] == 'success'){
            update_option( 'themeisle_subscribed_intergeo', true);
            wp_send_json_success(array("success" => true));
        }
    }
    wp_die();
}