<!DOCTYPE html>
<html>
<head>
    <title>Beautiful Invoice</title>
    <style>
        /* Reset default margin and padding */
        body, h1, h2, h3, p {
            margin: 0;
            padding: 0;
        }

        /* Global styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f0f0;
            color: #333;
        }

        /* Invoice container */
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 30px;
            background-color: #ffffff;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.1);
            border-radius: 20px;
        }

        /* Invoice header */
        .invoice-header {
            text-align: center;
            margin-bottom: 30px;
        }

        /* Invoice details */
        .invoice-details {
            margin-bottom: 30px;
        }

        /* Invoice item */
        .invoice-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #eee;
        }

        /* Highlight labels */
        .invoice-item span.label {
            font-weight: bold;
            color: #888;
            text-transform: uppercase;
        }

        /* Stylish heading for labels */
        h1, h2 {
            font-weight: 800;
            margin-bottom: 15px;
            color: #222;
        }

        /* Subtle hover effect */
        .invoice-item:hover {
            background-color: #f9f9f9;
        }

        /* Button styling */
        .print-button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 15px;
            cursor: pointer;
            font-size: 18px;
            text-align: center;
            transition: background-color 0.3s ease-in-out;
        }

        .print-button:hover {
            background-color: #0056b3;
        }

        /* Header style */
        .invoice-title {
            font-size: 48px;
            color: #333;
            margin-bottom: 20px;
        }

        /* Accent color */
        .accent {
            color: #ff6600;
        }

        /* Stylish separator */
        .separator {
            width: 100%;
            height: 2px;
            background-color: #ccc;
            margin: 30px 0;
        }

        /* Beautiful invoice type */
        .invoice-type {
            font-size: 28px;
            font-weight: 800;
            text-transform: uppercase;
            color: #ff6600;
            margin-bottom: 20px;
        }

        /* Elegant invoice background */
        .invoice-background {
            background-color: #f8f8f8;
            padding: 20px;
            border-radius: 15px;
            margin: 20px 0;
        }

        /* Gradient accent line */
        .accent-line {
            width: 100%;
            height: 4px;
            background: linear-gradient(to right, #ff6600, #ffa500);
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="invoice-header">
            <h1 class="invoice-title">Invoice</h1>
            <div class="invoice-type">Payment Summary</div>
        </div>
        <div class="invoice-details">
            <div class="invoice-background">
                <div class="invoice-item">
                    <span class="label">Client Name:</span>
                    <span class="accent"><?php echo $invoice_data->client_name; ?></span>
                </div>
                <div class="invoice-item">
                    <span class="label">Title:</span>
                    <span class="accent"><?php echo $invoice_data->title; ?></span>
                </div>
                <div class="invoice-item">
                    <span class="label">Payment Type:</span>
                    <span class="accent"><?php echo $invoice_data->payment_type === '1' ? 'Software Payment' : 'Service Payment'; ?></span>
                </div>
                <div class="invoice-item">
                    <span class="label">Date:</span>
                    <span class="accent"><?php echo $invoice_data->date; ?></span>
                </div>
                <div class="invoice-item">
                    <span class="label">Payment Way:</span>
                    <span class="accent"><?php echo $invoice_data->payment_way; ?></span>
                </div>
                <div class="invoice-item">
                    <span class="label">Payment Amount:</span>
                    <span class="accent"><?php echo $invoice_data->pyment_amount; ?></span>
                </div>
                <div class="invoice-item">
                    <span class="label">Due:</span>
                    <span class="accent"><?php echo $invoice_data->due; ?></span>
                </div>
                <div class="invoice-item">
                    <span class="label">Created At:</span>
                    <span class="accent"><?php echo $invoice_data->create_at; ?></span>
                </div>
            </div>
            <div class="accent-line"></div>
            <!-- Add more invoice items here as needed -->
        </div>
        <button class="print-button" onclick="window.print()">Print Invoice</button>
    </div>
</body>
</html>
