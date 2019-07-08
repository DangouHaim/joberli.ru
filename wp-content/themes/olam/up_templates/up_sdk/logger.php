<?php

function uplog($data) {
    global $wpdb;
    $wpdb->insert( 
        'up_logs',
        array( 
            'data' => $data,
        ), 
        array( 
            '%s'
        ) 
    );
}