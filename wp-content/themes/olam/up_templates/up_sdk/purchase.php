<?php

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

function isOrderDone($orderId) {
    if($orderId) {
        global $wpdb;
        $result = $wpdb->get_results("SELECT doneConfirmed FROM up_orders WHERE id = " . $orderId)[0];
        return $result->doneConfirmed;
    }
    return false;
}

function isOrderHasDoneRequest($orderId) {
    if($orderId) {
        global $wpdb;
        $result = $wpdb->get_results("SELECT done FROM up_orders WHERE id = " . $orderId)[0];
        return $result->done;
    }
    return false;
}

function isOrderHasCancelRequest($orderId) {
    if($orderId) {
        global $wpdb;
        $result = $wpdb->get_results("SELECT cancel FROM up_orders WHERE id = " . $orderId)[0];
        return $result->cancel;
    }
    return false;
}

function isOrderPostOwner($orderId) {
    $uid = get_current_user_id();
    if($orderId && $uid)
    {
        $download = edd_get_download(getPost($orderId));
        return $download->post_author == $uid;
    }
    return false;
}

function getOrderStatus($orderId) {
    $result = "";

    if(isOrderDone($orderId)) {
        $result = "Выполнен";
    } else {
        if(isCancelledOrder($orderId)) {
            $result = "Отменён";
        } else {
            if(isInProgress($orderId)) {
                $result = "Принят";
                if(isOrderHasCancelRequest($orderId)) {
                    $result .= ", Ждёт отмены";
                }
                if(isOrderHasDoneRequest($orderId)) {
                    $result .= ", Ждёт одобрения";
                }
            }
            else {
                $result = "Ожидает";
            }
        }
    }

    return $result;
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
        return $result->userId;
    }
    return false;
}

function getOrderPostOwner($orderId) {
    if($orderId) {
        $download = edd_get_download(getPost($orderId));
        return $download->post_author;
    }
    return false;
}

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
                'sum' => $sum,
                'postOwner' => $download->post_author
            ), 
            array( 
                '%d' 
            ) 
        );
        $orderId = $wpdb->insert_id;
        subtractAccount($sum, $uid);
        sendMessage($download->post_author, "Здравствуйте, хочу преобрести у вас услугу '" . $download->post_title . "'. Сумма уже внесена: "
            . $sum . "₽, мой номер заказа - " . $orderId . "."
        );
        return $orderId;
    }
}

function setOrderInProgress($orderId) {

    if($orderId) {

        if(!isOrderPostOwner($orderId)) {
            return "Ошибка доступа!";
        }

        if(isInProgress($orderId)) {
            return "Заказ уже выполняется!";
        }

        if(isCancelledOrder($orderId)) {
            return "Заказ уже отменён!";
        }

        if(isOrderDone($orderId)) {
            return "Заказ уже завершён!";
        }

        global $wpdb;
        $result = $wpdb->update( 
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

        sendMessage(getUser($orderId), "Здравствуйте, ваш заказ принят! Номер заказа - " . $orderId . ".");

        return $result;
    }
}

function cancelOrder($orderId) {

    if(!isUserOrder($orderId)) {
        return "Ошибка доступа!";
    }

    if(isCancelledOrder($orderId)) {
        return "Заказ уже отменён!";
    }

    if(isOrderDone($orderId)) {
        return "Заказ уже завершён!";
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

    $ownerId = getOrderPostOwner($orderId);
    if(!isInProgress($orderId)) {
        forceCancelOrder($orderId);
        sendMessage($ownerId, "Здравствуйте, я отменил заказ. Номер заказа - " . $orderId . ".");
    } else {
        sendMessage($ownerId, "Здравствуйте, я хотел бы отменить заказ " . $orderId . ".");
    }
}

function confirmOrderCancelation($orderId) {

    if(isCancelledOrder($orderId)) {
        return "Заказ уже отменён!";
    }

    if(!isOrderPostOwner($orderId)) {
        return "Ошибка доступа!";
    }

    if(isOrderDone($orderId)) {
        return "Заказ уже завершён!";
    }

    if($orderId) {
        forceCancelOrder($orderId);
        sendMessage(getUser($orderId), "Здравствуйте, ваш заказ успешно отменён. Номер заказа - " . $orderId . ".");
    }
}

function forceCancelOrder($orderId) {

    if(!isOrderPostOwner($orderId) && !isUserOrder($orderId)) {
        return "Ошибка доступа!";
    }

    if(isOrderDone($orderId)) {
        return "Заказ уже завершён!";
    }

    if(isCancelledOrder($orderId)) {
        return "Заказ уже отменён!";
    }

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

        $sum = (float)getSum($orderId);
        $percent = (float)($sum / 100);
        addAccount(($sum - $percent), getUser($orderId));
        addAccount($percent, 1);
        return $update;
    }
    return false;
}

function setOrderDone($orderId) {
    
    if(!isOrderPostOwner($orderId)) {
        return "Ошибка доступа!";
    }

    if(isCancelledOrder($orderId)) {
        return "Заказ уже отменён!";
    }

    if(isOrderHasCancelRequest($orderId)) {
        return "Заказ был отменён клиентом! Требуется подтверждение отмены...";
    }

    if(isOrderDone($orderId)) {
        return "Заказ уже завершён!";
    }

    if(isOrderHasDoneRequest($orderId)) {
        return "Заказ уже помечен как выполненный!";
    }

    if(!isInProgress($orderId)) {
        return "Заказ ещё не выполняется!";
    }

    if($orderId) {
        global $wpdb;
        $result = $wpdb->update( 
            'up_orders', 
            array( 
                'done' => 1
            ), 
            array( 
                'id' => $orderId
            ), 
            array( 
                '%d'
            ), 
            array( '%d' ) 
        );
        sendMessage(getUser($orderId), "Здравствуйте, ваш заказ готов! Номер заказа - " . $orderId . ".");
        return $result;
    }
}

function confirmOrderDone($orderId) {
    
    if(!isUserOrder($orderId)) {
        return "Ошибка доступа!";
    }

    if(isCancelledOrder($orderId)) {
        return "Заказ уже отменён!";
    }

    if(isOrderHasCancelRequest($orderId)) {
        return "Заказ был отменён клиентом! Требуется подтверждение отмены...";
    }

    if(isOrderDone($orderId)) {
        return "Заказ уже завершён!";
    }

    if(!isOrderHasDoneRequest($orderId)) {
        return "Заказ ещё не готов!";
    }

    if(!isInProgress($orderId)) {
        return "Заказ ещё не выполняется!";
    }

    if($orderId) {
        global $wpdb;
        $update = $wpdb->update( 
            'up_orders', 
            array( 
                'doneConfirmed' => 1
            ), 
            array( 
                'id' => $orderId
            ), 
            array( 
                '%d'
            ), 
            array( '%d' ) 
        );

        $sum = (float)getSum($orderId);
        $percent = (float)($sum / 10);
        addAccount(($sum - $percent), getOrderPostOwner($orderId));
        addAccount($percent, 1);
        sendMessage(getOrderPostOwner($orderId), "Здравствуйте, я подтверждаю выполнение заказа! Номер заказа - " . $orderId . ".");
        return $update;
    }

}

function getUserPurchases() {
    $uid = get_current_user_id();

    if($uid) {
        global $wpdb;
        return $wpdb->get_results("SELECT * FROM up_orders WHERE userId = " . $uid);
    }
}

function getUserOrders() {
    $uid = get_current_user_id();

    if($uid) {
        global $wpdb;
        return $wpdb->get_results("SELECT * FROM up_orders WHERE postOwner = " . $uid);
    }
}