<!DOCTYPE html>
<html>

<head>
    <title>Payment Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 28px;
            color: #237729;
        }

        .header p {
            margin: 5px 0 0;
            font-size: 14px;
            color: #555;
        }

        .details {
            margin-bottom: 20px;
        }

        .details table {
            width: 100%;
            border-collapse: collapse;
        }

        .details th,
        .details td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        .details th {
            background-color: #f2f2f2;
            font-weight: bold;
            color: #333;
        }

        .details td {
            font-size: 14px;
            color: #555;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #888;
        }

        .footer p {
            margin: 0;
        }

        .highlight {
            color: #237729;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Payment Receipt</h1>
            <p>Thank you for your payment!</p>
        </div>

        <div class="details">
            <table>
                <tr>
                    <th>Park</th>
                    <td class="highlight"><?= $transaction->park_label ?></td>
                </tr>
                <tr>
                    <th>Partner</th>
                    <td><?= $transaction->partner->name ?? 'N/A' ?></td>
                </tr>
                <tr>
                    <th>Travelers</th>
                    <td><?= $transaction->travelers ?></td>
                </tr>
                <tr>
                    <th>Stay Category</th>
                    <td><?= $transaction->staycatgory_lable ?></td>
                </tr>
                <tr>
                    <th>Start Date</th>
                    <td><?= date('M d, Y', strtotime($transaction->start_date)) ?></td>
                </tr>
                <tr>
                    <th>End Date</th>
                    <td><?= date('M d, Y', strtotime($transaction->end_date)) ?></td>
                </tr>
                <tr>
                    <th>Amount Paid</th>
                    <td class="highlight">₹<?= number_format($transaction->net_payment_price, 2) ?></td>
                </tr>
                <tr>
                    <th>Transaction ID</th>
                    <td class="highlight"><?= $transaction->id ?></td>
                </tr>
                <tr>
                    <th>Payment Date</th>
                    <td><?= date('M d, Y h:i A') ?></td>
                </tr>
                <tr>
                    <th>Additional Notes</th>
                    <td><?= nl2br($transaction->addional_notes) ?></td>
                </tr>
            </table>
        </div>

        <div class="footer">
            <p>Generated on <?= date('M d, Y h:i A') ?></p>
            <p>Walk Into The Wild</p>
        </div>
    </div>
</body>

</html>