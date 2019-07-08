<?php

function registerPartner( $user_id ) {

    if(isset($_COOKIE["partner"])) {

        $value = $_COOKIE["partner"];
        global $wpdb;

        if($user_id && $value) {
            return $wpdb->update( 
                'wp_users',
                array( 
                    'partnerId' => $value
                ), 
                array( 'ID' => $user_id ), 
                array( 
                    '%d'
                ), 
                array( '%d' ) 
            );
        }
    }
}

function initPartner() {
    if(isset($_GET["partner"])) {
        $value = $_GET["partner"];
        if($value) {
            setcookie("partner", $value, time()+360000);
        }
    }
}
add_action( 'init', 'initPartner');

function getPartnerLink() {
    return add_query_arg("partner", get_current_user_id(), get_site_url());
}

function getUserPartner($uid) {
    if($uid) {
        global $wpdb;
        $result = $wpdb->get_results("SELECT partnerId FROM wp_users WHERE ID = " . $uid)[0];
        return $result->partnerId;
    }
}

function getPartnerUsers() {
    
    $uid = get_current_user_id();

    if($uid) {
        global $wpdb;
        return $wpdb->get_results("SELECT * FROM wp_users WHERE partnerId = " . $uid);
    }
}