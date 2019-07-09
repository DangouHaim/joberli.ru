<?php

function prepareStaistics($uid, $sum, $source) {
    if($uid && $sum) {
        global $wpdb;

        $wpdb->insert(
            'up_pay_statistics',
            array(
                'sourceId' => $source,
                'userId' => $uid,
                'sum' => (float)$sum
            ),
            array(
              '%d',
              '%d',
              '%s'
            )
          );
        return $wpdb->insert_id;
    }
}

function getUserStatistics($uid) {
    if($uid) {
        global $wpdb;
        return $wpdb->get_results("SELECT o.*, s.sum AS postOwnerSum, ps.sum AS partnerSum, s.date AS completeDate
        
        FROM up_orders AS o

        LEFT JOIN up_pay_statistics AS s
        ON o.id = s.sourceId AND s.userId = o.postOwner
        
        LEFT JOIN wp_users AS u
        ON u.ID = o.postOwner
        
        LEFT JOIN up_pay_statistics AS ps
        ON o.id = ps.sourceId AND ps.userId = u.partnerId
        
        WHERE o.postOwner = " . $uid);
    }
}