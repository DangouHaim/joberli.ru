<?php

function prepareOrder($postId, $sum) {
    $uid = get_current_user_id();

    if($uid && $postId && $sum) {
        if(!checkSubtractAccount($sum)) {
            return "Недостаточно средств!";
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