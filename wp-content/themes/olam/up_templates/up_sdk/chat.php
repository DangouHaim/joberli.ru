<?php

function checkChat($toId) {
    $fromId = get_current_user_id();

    if($toId && $fromId) {
        
        $roomPlace = $toId . ":" . $fromId;
        if($toId > $fromId) {
            $roomPlace = $fromId . ":" . $toId;
        }
        $chatStatus = "private";
        $now = date("Y-m-d H:i:s");

        global $wpdb;

        $results = $wpdb->get_results("SELECT chat_id FROM wp_rcl_chats WHERE "
            . "chat_room = '" . $chatStatus . ":" . $roomPlace . "' "
        );

        if(!$results[0]->chat_id) {

            // Create chat
            $wpdb->insert( 
                'wp_rcl_chats', 
                array( 
                    'chat_room' => $chatStatus . ":" . $roomPlace,
                    'chat_status' => $chatStatus
                ), 
                array( 
                    '%s',
                    '%s'
                ) 
            );
            $chatId = $wpdb->insert_id;

            $wpdb->insert( 
                'wp_rcl_chat_users', 
                array( 
                    'room_place' => $chatId . ":" . $fromId,
                    'chat_id' => $chatId,
                    "user_id" => $fromId,
                    "user_activity" => $now,
                    "user_write" => 0,
                    "user_status" => 1
                ), 
                array( 
                    '%s',
                    '%d',
                    '%d',
                    '%s',
                    '%d',
                    '%d',
                ) 
            );

            $wpdb->insert( 
                'wp_rcl_chat_users', 
                array( 
                    'room_place' => $chatId . ":" . $toId,
                    'chat_id' => $chatId,
                    "user_id" => $toId,
                    "user_activity" => $now,
                    "user_write" => 0,
                    "user_status" => 1
                ), 
                array( 
                    '%s',
                    '%d',
                    '%d',
                    '%s',
                    '%d',
                    '%d',
                ) 
            );
            return $chatId;

        } else {
            return $results[0]->chat_id;
        }
    }
}

function sendMessage($toId, $message) {
    $fromId = get_current_user_id();
    if($toId && $fromId) {

        $chatId = checkChat($toId);

        if($chatId) {

            //Create message
            global $wpdb;
            $now = date("Y-m-d H:i:s");

            $wpdb->insert( 
                'wp_rcl_chat_messages', 
                array( 
                    'chat_id' => $chatId,
                    'user_id' => $fromId,
                    'message_content' => $message,
                    'message_time' => $now,
                    'private_key' => $toId,
                    'message_status' => 0
                ), 
                array( 
                    '%d',
                    '%d',
                    '%s',
                    '%s',
                    '%d',
                    '%d'
                ) 
            );

        }

    }
}