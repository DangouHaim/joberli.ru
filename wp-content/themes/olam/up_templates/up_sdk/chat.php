<?php

function checkChat($toId) {
    $fromId = get_current_user_id();

    if($toId && $fromId) {
        
        $roomPlace = $toId . ":" . $fromId;
        if($toId > $fromId) {
            $roomPlace = $fromId . ":" . $toId;
        }
        $chatStatus = "private";

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

            $wpdb->insert( 
                'wp_rcl_chat_messages', 
                array( 
                    'chat_id' => $chatId,
                    'user_id' => $fromId,
                    'message_content' => $message,
                    'private_key' => $toId,
                    'message_status' => 0,
                    'isNotification' => 1
                ), 
                array( 
                    '%d',
                    '%d',
                    '%s',
                    '%s',
                    '%d',
                    '%d',
                    '%d'
                ) 
            );

        }

    }
}

function getChats() {
    $uid = get_current_user_id();

    if($uid) {
        global $wpdb;
        return $wpdb->get_results("SELECT chat_id FROM wp_rcl_chat_users WHERE user_id = " . $uid);
    }
}

function getMessages($getNotifications = 0) {
    $uid = get_current_user_id();
    $result = array();

    if($uid) {
        global $wpdb;

        foreach(getChats() as $chat) {
            $messages = $wpdb->get_results("SELECT * FROM wp_rcl_chat_messages WHERE chat_id = " . $chat->chat_id . " AND user_id != " . $uid . " AND message_status = 0 AND isNotification = " . $getNotifications . " ORDER BY message_id DESC");
            foreach($messages as $message) {
                array_push($result, $message);
            }
        }
    }
    return $result;
}