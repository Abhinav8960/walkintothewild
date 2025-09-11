<?php

use business\assets\AppAsset;
use common\models\GeneralModel;
use yii\helpers\Url;


$webasset = $this->assetManager->getBundle('\business\assets\PartnerAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
AppAsset::register($this);

$this->title = 'Booked Users';
?>

<div class="title">
    <p style="font-weight: 700; font-size:25px"><?= $this->title ?></p>
</div>
<div class="wrapper_inner">
    <div class="row">
        <div class="col-lg-12">
            <div class="grid-view mb-3">
                <table class="table w-100 border-0 border_o">
                    <thead class="thead-grid-details">
                        <tr>
                            <th>User Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Transaction Date Time</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <?php foreach ($booked_users as $booked) { ?>
                        <tbody class="tbody-grid-leads py-3">
                            <tr>
                                <td><?= $booked->name ?></td>
                                <td><?= $booked->email ?></td>
                                <td><?= $booked->phone ?></td>
                                <td><?= $booked->transaction_datetime ?></td>
                                <td>
                                    <div class="price-container">
                                        <span style="font-size: 16px; color: #2E8B57;">₹</span>
                                        <span style="font-weight: bold; color: #2E8B57;"><?= $booked->received_amount ?></span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .grid-view {
        margin-bottom: 20px;
    }

    .thead-grid-details th {
        background-color: #C4E3BD !important;
        padding: 15px;
        text-align: left;
        font-weight: unset;
        color: #333;
    }

    .tbody-grid-leads td {
        padding: 12px 15px;
        border-bottom: 1px solid #eee;
        vertical-align: top;
    }

    .tbody-grid-leads tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .tbody-grid-leads tr:hover {
        background-color: #f0f8ff;
    }

    .display-image {
        max-width: 100%;
        height: auto;
        border-radius: 4px;
    }

    .price-container {
        display: flex;
        align-items: center;
    }

    .rupee-icon {
        width: 15px;
        margin-right: 5px;
        margin-bottom: 2px;
    }

    .active-user {
        background-color: #e0f7fa !important;
        border-left: 4px solid #00796b;
    }
</style>