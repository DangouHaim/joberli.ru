<?php

function register_partner( $user_id ) {

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

function init_partner() {
    if(isset($_GET["partner"])) {
        $value = $_GET["partner"];
        if($value) {
            setcookie("partner", $value, time()+360000);
        }
    }
}
add_action( 'init', 'init_partner');