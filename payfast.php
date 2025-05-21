<?php
require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

// Load environment variables
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// PayFast Credentials
$merchant_id = $_ENV['PAYFAST_MERCHANT_ID'];
$merchant_key = $_ENV['PAYFAST_MERCHANT_KEY'];
$return_url = "https://app.veridate.co.za/payment-success";
$cancel_url = "https://app.veridate.co.za/payment-cancel";
$notify_url = "https://app.veridate.co.za/payfast_notify"; 

// Determine PayFast environment (sandbox/live)
$payfast_base_url = ($_ENV['PAYFAST_ENV'] === 'sandbox')
    ? "https://sandbox.payfast.co.za/eng/process?"
    : "https://www.payfast.co.za/eng/process?";

// Payment Data
$order_id = uniqid();
$amount = $_POST['amount']; 
$item_name = $_POST['plan'];

// Build PayFast Query String
$data = array(
    "merchant_id" => $merchant_id,
    "merchant_key" => $merchant_key,
    "return_url" => $return_url,
    "cancel_url" => $cancel_url,
    "notify_url" => $notify_url,
    "m_payment_id" => $order_id,
    "amount" => number_format($amount, 2, '.', ''),
    "item_name" => $item_name
);

// Generate Signature
$signature = "";
foreach ($data as $key => $value) {
    $signature .= $key . "=" . urlencode(trim($value)) . "&";
}
$signature = rtrim($signature, "&");
$pf_signature = md5($signature);

// Final Payment URL
$payfast_url = $payfast_base_url . http_build_query($data);

// Return the payment URL as JSON
echo json_encode(["payment_url" => $payfast_url]);

?>


<?php

// PayFast credentials
$merchant_id = "your_merchant_id";
$merchant_key = "your_merchant_key";
$return_url = "https://yourapp.com/payment-success"; // Redirect after success
$cancel_url = "https://yourapp.com/payment-cancel"; // Redirect if canceled
$notify_url = "https://yourbackend.com/payfast_notify"; // PayFast IPN

// Payment Data
$order_id = uniqid(); // Unique order ID
$amount = $_POST['amount']; // Example: Get from Flutter request
$item_name = $_POST['plan']; // Subscription Plan Name

// Build PayFast Query String
$data = array(
    "merchant_id" => $merchant_id,
    "merchant_key" => $merchant_key,
    "return_url" => $return_url,
    "cancel_url" => $cancel_url,
    "notify_url" => $notify_url,
    "m_payment_id" => $order_id,
    "amount" => number_format($amount, 2, '.', ''),
    "item_name" => $item_name
);

// Generate Signature
$signature = "";
foreach ($data as $key => $value) {
    $signature .= $key . "=" . urlencode(trim($value)) . "&";
}
$signature = rtrim($signature, "&");
$pf_signature = md5($signature);

// Final Payment URL
$payfast_url = "https://www.payfast.co.za/eng/process?" . http_build_query($data);

// Send response back to Flutter
echo json_encode(["payment_url" => $payfast_url]);

?>
