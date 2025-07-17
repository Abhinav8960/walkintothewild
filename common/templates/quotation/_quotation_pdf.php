<?php

/**
 * @var $quotation \common\models\leads\LeadPartnerQuotes
 */
?>

<!DOCTYPE html>
<html>

<head>
    <title>Quotation PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
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
            padding: 8px;
        }

        .details th {
            background-color: #f2f2f2;
            text-align: left;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #888;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Quotation Details</h1>
    </div>

    <div class="details">
        <table>
            <tr>
                <th>Quotation ID</th>
                <td><?= $quotation->id ?></td>
            </tr>
            <tr>
                <th>Lead ID</th>
                <td><?= $quotation->lead_id ?></td>
            </tr>
            <tr>
                <th>Partner</th>
                <td><?= $quotation->partner->name ?? 'N/A' ?></td>
            </tr>
            <tr>
                <th>Travelers</th>
                <td><?= $quotation->travelers ?></td>
            </tr>
            <tr>
                <th>Stay Category</th>
                <td><?= \common\models\GeneralModel::staycategoryoption()[$quotation->stay_category_id] ?? 'N/A' ?></td>
            </tr>
            <tr>
                <th>Start Date</th>
                <td><?= date('M d, Y', strtotime($quotation->start_date)) ?></td>
            </tr>
            <tr>
                <th>End Date</th>
                <td><?= date('M d, Y', strtotime($quotation->end_date)) ?></td>
            </tr>
            <tr>
                <th>Additional Notes</th>
                <td><?= nl2br($quotation->addional_notes) ?></td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p>Generated on <?= date('M d, Y h:i A') ?></p>
    </div>
</body>

</html>