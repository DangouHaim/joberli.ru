<?php

function prepareOrder($postId, $sum) {
    $uid = get_current_user_id();

    if($uid && $postId && $sum) {
        if(!checkSubtractAccount($sum)) {
            return "Недостаточно средств!";
        }

        $download = edd_get_download($postId);
        if($download->post_author == $uid) {
            return "Пользователь не может заказывать СВОИ услуги!";
        }

        global $wpdb;

        $wpdb->insert( 
            'up_orders', 
            array(
                'userId' => $uid,
                'postId' => $postId,
                'sum' => $sum
            ), 
            array( 
                '%d' 
            ) 
        );
        subtractAccount($sum, $uid);
        return $wpdb->insert_id;
    }
}

function cancelOrder() {

}

function confirmOrderCancelation() {

}

function setOrderInProgress() {

}

function setOrderDone() {

}

function confirmOrderDone() {

}