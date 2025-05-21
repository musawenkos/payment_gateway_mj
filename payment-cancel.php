<?php
require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

// Load environment variables
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Canceled</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            padding: 50px;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px #ccc;
            display: inline-block;
        }
        h2 {
            color: #dc3545;
        }
        p {
            font-size: 18px;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            text-decoration: none;
            background-color: #dc3545;
            color: white;
            border-radius: 5px;
        }
        a:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>❌ Payment Canceled</h2>
        <p>You have canceled the payment process.</p>
        <p>If this was a mistake, you can try again.</p>
        <a href="index.html">Try Again</a>
    </div>

</body>
</html>
