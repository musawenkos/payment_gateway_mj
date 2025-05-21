<?php
require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Log IPN response
$data = file_get_contents("php://input");
file_put_contents("payfast_ipn_log.txt", $data, FILE_APPEND);

// Process IPN response
$pfData = json_decode($data, true);
$payment_status = $pfData['payment_status'] ?? 'FAILED';

if ($payment_status == "COMPLETE") {
    file_put_contents("payfast_success_log.txt", "Payment successful\n", FILE_APPEND);
} else {
    file_put_contents("payfast_failed_log.txt", "Payment failed\n", FILE_APPEND);
}

?>
