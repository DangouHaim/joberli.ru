<?php

function initAccount() {
    $uid = get_current_user_id();
    if($uid) {
        global $wpdb;
        $account = $wpdb->get_results("SELECT account FROM up_account WHERE userId = " . $uid)[0];
    
        if(!$account) {
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
    if($uid && $value) {
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

function addAccount($value, $uid) {
    if($uid && $value) {
        $current = (float)getAccount($uid);
        $result = (float)$value + $current;
        updateAccount($result, $uid);
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