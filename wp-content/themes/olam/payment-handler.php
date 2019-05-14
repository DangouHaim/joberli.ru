<?php

if(isset($_GET["payhandler"])) {
    $unitPay = new UnitPay($secretKey);

    try {
        // Validate request (check ip address, signature and etc)
        $unitPay->checkHandlerRequest();

        list($method, $params) = array($_GET['method'], $_GET['params']);
        
        // Very important! Validate request with your order data, before complete order
        $results = $wpdb->get_results("SELECT userId FROM up_pays WHERE id = " . $params['account']);
        
        $uid = $results[0]->userId;
        if (
            $params['projectId'] != $projectId &&
            !$uid
        ) {
            // logging data and throw exception
            throw new InvalidArgumentException('Order validation Error!');
        }
        switch ($method) {
            // Just check order (check server status, check order in DB and etc)
            case 'check':
                echo $unitPay->getSuccessHandlerResponse('Check Success. Ready to pay.');
                break;
            // Method Pay means that the money received
            case 'pay':
                // Please complete order
                addAccount((float)$params['orderSum'], $uid);
                echo $unitPay->getSuccessHandlerResponse('Pay Success');
                break;
            // Method Error means that an error has occurred.
            case 'error':
                // Please log error text.
                echo $unitPay->getSuccessHandlerResponse('Error logged');
                break;
        }
    // Oops! Something went wrong.
    } catch (Exception $e) {
        $unitPay->getErrorHandlerResponse($e->getMessage());
    }
    die;
}