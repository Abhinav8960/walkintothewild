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
            <div class="details-packages mb-3">
                <table class="table w-100 border-0 border_o">
                    <thead class="thead-details">
                        <tr>
                            <th>Title</th>
                            <th>Cut Off Date</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>No of Safari</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody class="tbody-leads py-3">
                        <tr>
                            <td><?= $share_safari->share_safari_title ?></td>

                            <td><?= $share_safari->cut_off_date ?></td>
                            <td><?= $share_safari->start_date ?></td>
                            <td><?= $share_safari->end_date ?></td>
                            <td><?= $share_safari->no_of_safari ?></td>
                            <td>
                                <div class="price-container">
                                    <span style="font-weight: bold; color: #2E8B57; margin-right:5px">₹</span>
                                    <span style="font-weight: bold; color: #2E8B57;"><?= GeneralModel::number_format_indian($share_safari->cost_per_person) ?></span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="details-packages mb-3">
                <table class="table w-100 border-0 border_o">
                    <thead class="thead-details">
                        <tr>
                            <th>User Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Transaction Date Time</th>
                            <th>No of Seat</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <?php foreach ($booked_users as $booked) { ?>
                        <tbody class="tbody-leads py-3">
                            <tr>
                                <td><?= $booked->name ?></td>
                                <td><?= $booked->email ?></td>
                                <td><?= $booked->phone ?></td>
                                <td><?= $booked->transaction_datetime ?></td>
                                <td><?= $booked->travelers ?></td>
                                <td>
                                    <div class="price-container">
                                        <span style="font-weight: bold; color: #2E8B57; margin-right:5px">₹</span>
                                        <span style="font-weight: bold; color: #2E8B57;"><?= GeneralModel::number_format_indian($booked->received_amount) ?></span>
                                    </div>
                                </td>
                                <td>
                                    <a href="<?= Url::toRoute(['booked-user-chat', 'share_safari_id' => $share_safari->id, 'share_safari_lead_id' => $booked->share_safari_lead_id]) ?>">
                                        <img src="<?= $this->params['baseurl'] ?>/images/chat.png" alt="Chat" width="20" height="20">
                                    </a>
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
    .details-packages {
        margin-bottom: 20px;
    }

    .thead-details th {
        background-color: #C4E3BD !important;
        padding: 15px;
        text-align: left;
        font-weight: unset;
        color: #333;
    }

    .tbody-leads td {
        padding: 12px 15px;
        border-bottom: 1px solid #eee;
        vertical-align: top;
    }

    .tbody-leads tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .tbody-leads tr:hover {
        background-color: #f0f8ff;
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
</style>