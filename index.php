<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PayFast Test Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            margin: 40px;
        }
        form {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px #ccc;
            display: inline-block;
        }
        input, select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            background-color: #28a745;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

    <h2>Test PayFast Payment Gateway</h2>
    <form id="payfastForm">
        <label for="plan">Choose a Subscription Plan:</label>
        <select id="plan" name="plan">
            <option value="basic">Basic - R10</option>
            <option value="business">Business - R100</option>
            <option value="premium">Premium - Custom Pricing</option>
        </select>

        <label for="amount">Enter Amount:</label>
        <input type="number" id="amount" name="amount" value="10.00" required>

        <button type="button" onclick="submitForm()">Proceed to Payment</button>
    </form>

    <div id="response"></div>

    <script>
        function submitForm() {
            const formData = new FormData(document.getElementById("payfastForm"));

            fetch("payfast.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.payment_url) {
                    document.getElementById("response").innerHTML = `<p>Redirecting to PayFast...</p>`;
                    window.location.href = data.payment_url; // Redirect to PayFast
                } else {
                    document.getElementById("response").innerHTML = `<p style="color:red;">Error processing payment.</p>`;
                }
            })
            .catch(error => console.error("Error:", error));
        }
    </script>

</body>
</html>
