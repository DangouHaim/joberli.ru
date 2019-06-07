<?php

function purchase() {
    if(is_user_logged_in()) {
        $uid = get_current_user_id();
        if($uid && isset($_POST["postId"])) {

            if(!isset($_POST["priceNumber"])) {
                $price = edd_price($_POST["postId"], false);
            } else {
                $price = edd_price($_POST["postId"], false, $_POST["priceNumber"]);
            }

            $price = (float) escape_htcml($price, "span");

            if($price) {

                $data = prepareOrder($_POST["postId"], $price);
                if(intval($data)) {
                    wp_send_json( $data );
                } else {
                    wp_send_json_error( $data, 422 );
                }

            }
        }
    }
    die;
}
add_action('wp_ajax_purchase', 'purchase');
add_action('wp_ajax_nopriv_purchase', 'purchase');


function cancel_purchase() {
    if(is_user_logged_in()) {
        $uid = get_current_user_id();
        if($uid && isset($_POST["orderId"])) {
            
            $data = cancelOrder($_POST["orderId"]);
            if(intval($data)) {
                wp_send_json( $data );
            } else {
                wp_send_json_error( $data );
            }

        }
    }
    die;
}
add_action('wp_ajax_cancelPurchase', 'cancel_purchase');
add_action('wp_ajax_nopriv_cancelPurchase', 'cancel_purchase');

function confirm_order_done() {
    if(is_user_logged_in()) {
        $uid = get_current_user_id();
        if($uid && isset($_POST["orderId"])) {
            
            $data = confirmOrderDone($_POST["orderId"]);
            if(intval($data)) {
                wp_send_json( $data );
            } else {
                wp_send_json_error( $data );
            }

        }
    }
    die;
}
add_action('wp_ajax_confirmOrderDone', 'confirm_order_done');
add_action('wp_ajax_nopriv_confirmOrderDone', 'confirm_order_done');