<?php


if(is_user_logged_in()) {
    // check payout
    if(isset($_POST["payOut"])) {
        $value = (float)$_POST["payOut"];
        $uid = get_current_user_id();

        if(!checkSubtractAccount($value)) {
            wp_send_json_error("У вас недостаточно средств");
            die;
        }

        if($uid && $value && checkSubtractAccount($value)) {
            
            $unitPay = new UnitPay($partnerSecretKey);

            $tid = prepareTransaction((float)$value);
        
            $response = $unitPay->api('massPayment', [
            'sum'     => $value,
            'purse'     => $_POST["purse"],
            'login'     => $partnerLogin,
            'transactionId'     => $tid,
            'paymentType'     => $_POST["type"],
            ]);
            
            if(!isset($response->error->message)) {
                subtractAccount($value, $uid);
            } else {
                $code = $response->error->code;
                abortTransaction($tid, $code);
            }
            
            // If need user redirect on Payment Gate
            if (isset($response->result->type)
            && $response->result->type == 'redirect') {
            // Url on PaymentGate
            $redirectUrl = $response->result->redirectUrl;
            // Payment ID in Unitpay (you can save it)
            $paymentId = $response->result->paymentId;
            // User redirect
            header("Location: " . $redirectUrl);
            
            // If without redirect (invoice)
            } elseif (isset($response->result->type)
            && $response->result->type == 'invoice') {
            // Url on receipt page in Unitpay
            $receiptUrl = $response->result->receiptUrl;
            // Payment ID in Unitpay (you can save it)
            $paymentId = $response->result->paymentId;
            // Invoice Id in Payment Gate (you can save it)
            $invoiceId = $response->result->invoiceId;
            // User redirect
            header("Location: " . $receiptUrl);
            
            // If error during api request
            } elseif (isset($response->error->message)) {
                $error = $response->error->message;
                wp_send_json_error($error);
                die;
            }
        }
    }

    // add balance request
    if(isset($_POST["addAccountValue"])) {
        $value = (float)$_POST["addAccountValue"];
        if($value) {
        $orderNumber = prepareOrderNumber();
        
        if($orderNumber) {
            $orderId = $orderNumber;
            
            $unitPay = new UnitPay($secretKey);
    
            $orderSum = $value;
    
            $redirectUrl = $unitPay->form(
                $publicId,
                $orderSum,
                $orderId,
                $orderDesc,
                $orderCurrency
            );
            
            header("Location: " . $redirectUrl);
        }
        }
        die;
    }

    /* UPDATE TRANSACTIONS FOR CURRENT USER */
    $tid = getLatestTransaction();
    if($tid) {
        $unitPay = new UnitPay($partnerSecretKey);

        $response = $unitPay->api('massPaymentStatus', [
            'login'     => $partnerLogin,
            'transactionId'     => $tid,
        ]);

        // Update transaction with subtracting money from user account
        if(isset($response->result->status)) {
            $result = $response->result;

            if($result->status == "success") {
                updateTransaction($tid);
            }
        } elseif (isset($response->result->type)
        && $response->result->type == 'redirect') {
        // Url on PaymentGate
        $redirectUrl = $response->result->redirectUrl;
        // Payment ID in Unitpay (you can save it)
        $paymentId = $response->result->paymentId;
        // User redirect
        header("Location: " . $redirectUrl);

        // If without redirect (invoice)
        } elseif (isset($response->result->type)
        && $response->result->type == 'invoice') {
        // Url on receipt page in Unitpay
        $receiptUrl = $response->result->receiptUrl;
        // Payment ID in Unitpay (you can save it)
        $paymentId = $response->result->paymentId;
        // Invoice Id in Payment Gate (you can save it)
        $invoiceId = $response->result->invoiceId;
        // User redirect
        header("Location: " . $receiptUrl);

        // If error during api request
        } elseif (isset($response->error->message)) {
            $error = $response->error->message;
            $code = $response->error->code;

            abortTransaction($tid, $code);

            wp_send_json_error( $error );
            die;
        }
    }
    /* UPDATE TRANSACTIONS FOR CURRENT USER END */
}

/* PAYMENT HANDLER */
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
                wp_send_json_error( $unitPay->getSuccessHandlerResponse('Error logged') );
                die;
                break;
        }
    // Oops! Something went wrong.
    } catch (Exception $e) {
        $unitPay->getErrorHandlerResponse($e->getMessage());
        wp_send_json_error( $e->getMessage() );
        die;
    }
    die;
}
/* PAYMENT HANDLER END */