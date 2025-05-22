<?php
require __DIR__ . '/vendor/autoload.php';
use Payfast\PayfastCommon\PayfastCommon;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();



// Ensure the page returns a 200 OK header for Payfast to recognize it
header('HTTP/1.0 200 OK');
flush();

try {
    // Initialize PayfastCommon for ITN validation
    $pfHost = ($_ENV['PAYFAST_ENV'] == 'sandbox') ? 'sandbox.payfast.co.za' : 'www.payfast.co.za';
    
    // Validate the ITN
    $pfData = $_POST;
    $pfParamString = '';
    
    foreach ($pfData as $key => $val) {
        if ($key !== 'signature') {
            $pfParamString .= $key . '=' . urlencode($val) . '&';
        }
    }
    $pfParamString = substr($pfParamString, 0, -1);
    
    $passPhrase = $_ENV['PAYFAST_API_PASSPHRASE']; // Replace with your passphrase
    if (!empty($passPhrase)) {
        $pfParamString .= '&passphrase=' . urlencode($passPhrase);
    }
    
    $signature = md5($pfParamString);
    
    if ($signature === $_POST['signature']) {
        // Signature is valid, process the payment
        $paymentStatus = $_POST['payment_status'];
        $transactionId = $_POST['pf_payment_id'];
        $amount = $_POST['amount_gross'];
        
        if ($paymentStatus === 'COMPLETE') {
            // Payment successful, update your database or perform other actions
            file_put_contents('notify.txt', "Payment successful: Transaction ID $transactionId, Amount: $amount\n", FILE_APPEND);
        } else {
            // Payment failed or cancelled
            file_put_contents('notify.txt', "Payment failed: Transaction ID $transactionId\n", FILE_APPEND);
        }
    } else {
        // Invalid signature
        file_put_contents('notify.txt', "Invalid signature\n", FILE_APPEND);
    }
} catch (Exception $e) {
    file_put_contents('notify.txt', 'Error: ' . $e->getMessage() . "\n", FILE_APPEND);
}
?>