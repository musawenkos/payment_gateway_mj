<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$merchant_id = $_ENV['PAYFAST_MERCHANT_ID'];
$merchant_key = $_ENV['PAYFAST_MERCHANT_KEY'];
$passphrase = $_ENV['PAYFAST_API_PASSPHRASE'] ?? "";

$return_url = "http://domain_name/payment-success.php";
$cancel_url = "http://domain_name/payment-cancel.php";
$notify_url = "http://domain_name/payfast_notify.php";

$amount = number_format("10.00", 2, '.', '');
$plan_name = $_POST['plan'];
$billing_date = date('Y-m-d', strtotime("+1 month"));
$frequency = $_POST['frequency'] ?? "3";
$cycles = $_POST['cycles'];
$payment_method = $_POST['payment_method'];


$order_id = uniqid();


$data = [
    "merchant_id" => $merchant_id,
    "merchant_key" => $merchant_key,
    "return_url" => $return_url,
    "cancel_url" => $cancel_url,
    "notify_url" => $notify_url,
    "m_payment_id" => $order_id,
    "amount" => $amount,
    "item_name" => "business",
    "subscription_type" => 1, 
    "billing_date" => $billing_date, 
    "recurring_amount" => $amount,
    "frequency" => $frequency,
    "cycles" => "0",
    "payment_method" => $payment_method 
];


ksort($data);

$query_string = "";
foreach ($data as $key => $value) {
    if (!empty($value)) { 
        $query_string .= "$key=" . urlencode(trim($value)) . "&";
    }
}
$query_string = rtrim($query_string, "&"); 

if (!empty($passphrase)) {
    $query_string .= "&passphrase=" . urlencode($passphrase);
}

$pf_signature = md5($query_string);

$data['signature'] = $pf_signature;

$payfast_url = "https://www.payfast.co.za/eng/process?" . http_build_query($data);

file_put_contents("payfast_debug.txt", "Query String: " . $query_string . "\nGenerated Signature: " . $pf_signature, FILE_APPEND);

echo json_encode(["payment_url" => $payfast_url]);
?>
