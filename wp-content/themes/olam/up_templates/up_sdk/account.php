<?php
$_DEBUG = false;

if(!$_DEBUG) {
    error_reporting(0);
}

require_once ('chat.php');
require_once ('purchase.php');
require_once ('orderInfo.php');
require_once ('partner.php');
require_once ('logger.php');
require_once ('UnitPay.php');

require_once ('purchase-handlers.php');
require_once ('account-handlers.php');

function initAccount() {
    $uid = get_current_user_id();
    if($uid) {
        global $wpdb;
        $account = $wpdb->get_results("SELECT account FROM up_account WHERE userId = " . $uid)[0];
    
        if($account == null) {
            $wpdb->insert( 
                'up_account', 
                array( 
                    'userId' => $uid,
                ), 
                array( 
                    '%d'
                ) 
            );
        }
    }
}

initAccount();

function getAccount($uid) {
    if(!$uid) {
        $uid = get_current_user_id();
    }
    if($uid) {
        global $wpdb;
        $result = $wpdb->get_results("SELECT account FROM up_account WHERE userId = " . $uid)[0];
        return $result->account;
    }
}

function updateAccount($value, $uid) {
    if($uid && $value >= 0) {
        global $wpdb;
        return $wpdb->update( 
            'up_account', 
            array( 
                'account' => (float)$value
            ), 
            array( 'userId' => $uid ), 
            array( 
                '%s'
            ), 
            array( '%d' ) 
        );
    }
}

function prepareOrderNumber() {
    $uid = get_current_user_id();

    if($uid) {
        global $wpdb;

        $wpdb->insert( 
            'up_pays', 
            array( 
              'userId' => $uid
            ), 
            array( 
              '%d' 
            ) 
          );
        return $wpdb->insert_id;
    }
}

function addAccount($value, $uid) {
    if($uid && $value >= 0) {
        $current = (float)getAccount($uid);
        $result = (float)$value + $current;
        updateAccount($result, $uid);
    }
}

function checkSubtractAccount($value) {
    $uid = get_current_user_id();

    if($uid && $value >= 0) {
        $current = (float)getAccount($uid);
        $result = $current - (float)$value;
        if($result >= 0) {
            return true;
        }
        return false;
    }
}

function subtractAccount($value, $uid) {
    if($uid && $value >= 0) {
        $current = (float)getAccount($uid);
        $result = $current - (float)$value;
        if($result >= 0) {
            updateAccount($result, $uid);
            return true;
        }
        return false;
    }
}

function prepareTransaction($value) {
    $uid = get_current_user_id();

    if($uid && $value) {
        global $wpdb;

        $wpdb->insert( 
            'up_transactions', 
            array( 
              'userId' => $uid,
              'value' => (float)$value
            ), 
            array( 
              '%d',
              '%s'
            ) 
          );
        return $wpdb->insert_id;
    }
}

function updateTransaction($tid) {
    $uid = get_current_user_id();

    if($uid) {
        if(checkSubtractAccount($uid)) {
            global $wpdb;
            $result = $wpdb->get_results("SELECT status FROM up_transactions WHERE userId = " . $uid . " AND id = " . $tid)[0];
            if($result->status == "wait") {
                $result = $wpdb->update( 
                    'up_transactions', 
                    array( 
                        'status' => "done"
                    ), 
                    array( 'userId' => $uid, 'id' => $tid, ), 
                    array( 
                        '%s'
                    ), 
                    array( '%d' ) 
                );
            }
        }
    }
}

function abortTransaction($tid, $code) {
    $uid = get_current_user_id();
    if($uid && $tid) {
        global $wpdb;
        $result = $wpdb->get_results("SELECT status, value FROM up_transactions WHERE userId = " . $uid . " AND id = " . $tid)[0];
        if($result->status == "wait") {
            $wpdb->update( 
                'up_transactions', 
                array( 
                    'status' => "failed",
                    'code' => $code
                ), 
                array( 'userId' => $uid, 'id' => $tid, ), 
                array( 
                    '%s'
                )
            );
        }
    }
}

function abortTransactionWithPayBack($tid, $code) {
    $uid = get_current_user_id();
    if($uid && $tid) {
        global $wpdb;
        $result = $wpdb->get_results("SELECT status, value FROM up_transactions WHERE userId = " . $uid . " AND id = " . $tid)[0];
        if($result->status == "wait") {
            $res = $wpdb->update( 
                'up_transactions', 
                array( 
                    'status' => "failed",
                    'code' => $code
                ), 
                array( 'userId' => $uid, 'id' => $tid, ), 
                array( 
                    '%s'
                ), 
                array( '%d' ) 
            );
            if($res) {
                addAccount($result->value, $uid);
            }
        }
    }
}

function getLatestTransaction() {
    $uid = get_current_user_id();

    if($uid) {
        global $wpdb;
        return $wpdb->get_results("SELECT id FROM up_transactions WHERE userId = " . $uid . " AND status = 'wait'")[0]->id;
    }
}