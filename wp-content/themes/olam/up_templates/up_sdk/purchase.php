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

function isInProgress($orderId) {
    if($orderId) {
        global $wpdb;
        $result = $wpdb->get_results("SELECT inProgress FROM up_orders WHERE id = " . $orderId)[0];
        return $result->inProgress;
    }
    return false;
}

function isUserOrder($orderId) {
    $uid = get_current_user_id();
    if($uid && $orderId) {
        global $wpdb;
        $result = $wpdb->get_results("SELECT userId FROM up_orders WHERE id = " . $orderId)[0];
        return $result->userId == $uid;
    }
    return false;
}

function isCancelledOrder($orderId) {
    if($orderId) {
        global $wpdb;
        $result = $wpdb->get_results("SELECT cancelConfirmed FROM up_orders WHERE id = " . $orderId)[0];
        return $result->cancelConfirmed;
    }
    return false;
}

function getPost($orderId) {
    if($orderId) {
        global $wpdb;
        $result = $wpdb->get_results("SELECT postId FROM up_orders WHERE id = " . $orderId)[0];
        return $result->postId;
    }
    return false;
}

function getSum($orderId) {
    if($orderId) {
        global $wpdb;
        $result = $wpdb->get_results("SELECT sum FROM up_orders WHERE id = " . $orderId)[0];
        return (float)$result->sum;
    }
    return false;
}

function getUser($orderId) {
    if($orderId) {
        global $wpdb;
        $result = $wpdb->get_results("SELECT userId FROM up_orders WHERE id = " . $orderId)[0];
        return (float)$result->userId;
    }
    return false;
}

function setOrderInProgress($orderId) {
    $uid = get_current_user_id();

    if($uid && $orderId) {

        $download = edd_get_download(getPost($orderId));
        if($download->post_author != $uid) {
            return "Ошибка доступа!";
        }

        if(isInProgress($orderId)) {
            return "Заказ уже в процессе!";
        }

        global $wpdb;
        return $wpdb->update( 
            'up_orders', 
            array( 
                'inProgress' => 1
            ), 
            array( 
                'id' => $orderId
            ), 
            array( 
                '%d'
            ), 
            array( '%d' ) 
        );
    }
}

function cancelOrder($orderId) {
    if(!isUserOrder($orderId)) {
        return "Ошибка доступа!";
    }

    if(isCancelledOrder($orderId)) {
        return "Заказ уже отменён!";
    }

    global $wpdb;
    $wpdb->update( 
        'up_orders', 
        array( 
            'cancel' => 1
        ), 
        array( 
            'id' => $orderId
        ), 
        array( 
            '%d'
        ), 
        array( '%d' ) 
    );

    if(!isInProgress($orderId)) {
        forceCancelOrder($orderId);
    }
}

function confirmOrderCancelation($orderId) {
    $uid = get_current_user_id();

    if(isCancelledOrder($orderId)) {
        return "Заказ уже отменён!";
    }

    $download = edd_get_download(getPost($orderId));
    if($download->post_author != $uid) {
        return "Ошибка доступа!";
    }

    if($uid && $orderId) {
        forceCancelOrder($orderId);
    }
}

function forceCancelOrder($orderId) {
    if($orderId) {
        global $wpdb;
        $update = $wpdb->update( 
            'up_orders', 
            array( 
                'cancelConfirmed' => 1
            ), 
            array( 
                'id' => $orderId
            ), 
            array( 
                '%d'
            ), 
            array( '%d' ) 
        );

        addAccount(getSum($orderId), getUser($orderId));
        return $update;
    }
    return false;
}

function setOrderDone() {

}

function confirmOrderDone() {

}