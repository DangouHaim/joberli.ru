<?php
$_DEBUG = true;
require_once ('orderInfo.php');
require_once ('UnitPay.php');

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

function abortTransactionWithPayBack($tid) {
    $uid = get_current_user_id();

    if($uid && $tid) {
        global $wpdb;
        $result = $wpdb->get_results("SELECT status, value FROM up_transactions WHERE userId = " . $uid . " AND id = " . $tid)[0];
        if($result->status == "wait") {
            $res = $wpdb->update( 
                'up_transactions', 
                array( 
                    'status' => "failed"
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

function abortTransaction($tid) {
    $uid = get_current_user_id();

    if($uid && $tid) {
        global $wpdb;
        $result = $wpdb->get_results("SELECT status, value FROM up_transactions WHERE userId = " . $uid . " AND id = " . $tid)[0];
        if($result->status == "wait") {
            $wpdb->update( 
                'up_transactions', 
                array( 
                    'status' => "failed"
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

function getLatestTransaction() {
    $uid = get_current_user_id();

    if($uid) {
        global $wpdb;
        return $wpdb->get_results("SELECT id FROM up_transactions WHERE userId = " . $uid . " AND status = 'wait'")[0]->id;
    }
}


// check payout
if(isset($_POST["payOut"])) {
    $value = (float)$_POST["payOut"];
    $uid = get_current_user_id();

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
            abortTransaction($tid);
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
            if($_DEBUG) {
                print 'Error: '.$error;
            }
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
        if($code >= 100 && $code <= 106 
        || $code == 201 
        || $code == -32000
        || $code == -32602
        || $code == -32603) {
            abortTransactionWithPayBack($tid);
        }
        
        if($_DEBUG) {
            print 'Error: '.$error;
        }
    }
}
/* UPDATE TRANSACTIONS FOR CURRENT USER END */

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
                if($_DEBUG) {
                    echo $unitPay->getSuccessHandlerResponse('Error logged');
                }
                break;
        }
    // Oops! Something went wrong.
    } catch (Exception $e) {
        $unitPay->getErrorHandlerResponse($e->getMessage());
    }
    die;
}
/* PAYMENT HANDLER END */