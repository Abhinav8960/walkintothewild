<?php

use support\assets\AppAsset;
use common\models\GeneralModel;
use common\models\leads\LeadPartnerQuotes;
use yii\helpers\Html;
use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\support\assets\NovaAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
$this->title = 'Leads(' . $model->sourceLabel . ')';
$this->params['title'] = $this->title;

AppAsset::register($this);


?>

<!-- <div class="row mb-5 mt-4 itenary_tabs">
    <div class="col-lg-12 col-xl-12 safartabs position-relative">
        <table class="table table-bordered">
            <thead>
                <th>Name</th>
                <th>Safaris</th>
                <th>Travelers</th>
                <th>Accomodation</th>
                <th>User Notes</th>
                <th>Travel Date looking For</th>
                <th>Lead Received Date</th>
                <th>Payment Info</th>
            </thead>
            <tbody>
                <tr>
                    <td><?= $model->displayLabel ?></td>
                    <td><?= !empty($model->safaris) ? $model->safaris : ''; ?></td>
                    <td><?= !empty($model->travelers) ? $model->travelers : '' ?></td>
                    <td><?= !empty($model->staycatgory) ? $model->staycatgory->title : '' ?></td>
                    <td><?= !empty($model->user_notes) ? $model->user_notes : '' ?></td>
                    <td>
                        <?php
                        $str = date('d M, Y', strtotime($model->from_date));
                        if (!empty($model->to_date)) {
                            $str .= '- ' . date('d M, Y', strtotime($model->to_date));
                        }
                        echo $str;
                        ?>
                    </td>
                    <td><?= date('d M, Y h:i A', $model->created_at) ?></td>
                    <td>
                        <?php
                        $str = '';
                        if ($model->is_payment_received) {
                            $str .= '<span class="badge badge-success">Payment Received</span>';
                            if (!empty($model->transaction_datetime)) {
                                $str .= '<br><b>Payment Date</b>: ' . date('d M, Y H:i A', strtotime($model->transaction_datetime));
                            }
                            if (!empty($model->transaction_id)) {
                                $str .= '<br><b>Transaction Id</b>: ' .  $model->transaction_id;
                            }
                            if (!empty($model->booked_operator_id)) {
                                $str .= '<br><b>Operator Booked</b>: ' .  $model->bookedpartner->business_name;
                            }
                        } else {
                            $str .= '<span class="badge badge-danger">Payment Not Received</span>';
                        }

                        $str .= '<br><b><a style="color: black !important;" href="/log/transaction?TransactionSearch[lead_id]=' . $model->id . '" target="_blank">All Transaction</b>: </a>';
                        echo $str;

                        ?>

                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4>Quotations</h4>
                <table class="table table-responsive table-bordered">
                    <thead>
                        <th>Operator</th>
                        <th>Safaris</th>
                        <th>Travelers</th>
                        <th>Accomodation</th>
                        <th>Travel Date looking For</th>
                        <th>Info</th> -->
<!-- <th>Partner selling price</th>
                        <th>Platform Partner Fees Percentage</th>
                        <th>Platform Partner Fees</th>
                        <th>Partner net selling price</th>
                        <th>Platform customer discount</th> -->
<!-- <th>Net payment price</th>
                        <th>No of installment</th>
                        <th>Lead Received Date</th>
                        <th>Validity Date</th>
                        <th>Permit Booking Date</th>
                        <th>Payment Link</th> -->
<!-- </thead>
                    <tbody>
                        <?php if (count($quotations) > 0) { ?>
                            <?php foreach ($quotations as $quotation) { ?>
                                <tr class="<?= $quotation->is_payment_received == true ? 'bg-warning' : '' ?>">
                                    <td><?= $quotation->partner->business_name ?></td>
                                    <td><?= !empty($quotation->safaris) ? $quotation->safaris : ''; ?></td>
                                    <td><?= !empty($quotation->travelers) ? $quotation->travelers : '' ?></td>
                                    <td><?= !empty($quotation->staycatgory) ? $quotation->staycatgory->title : '' ?></td>
                                    <td>
                                        <?php
                                        $str = date('d M, Y', strtotime($quotation->start_date));
                                        if (!empty($quotation->end_date)) {
                                            $str .= '- ' . date('d M, Y', strtotime($quotation->end_date));
                                        }
                                        echo $str;
                                        ?>
                                    </td>
                                    <td>
                                        <?= $quotation->name ?>
                                        <?= $quotation->email ?>
                                        <?= $quotation->phone ?>
                                    </td> -->
<!-- <td>₹<?= $quotation->partner_selling_price ?></td>
                                    <td><?= $quotation->plateform_partner_fees_percentage ?>%</td>
                                    <td>₹<?= $quotation->plateform_partner_fees ?></td>
                                    <td>₹<?= $quotation->partner_net_selling_price ?></td>
                                    <td>₹<?= $quotation->plateform_customer_discount ?></td> -->
<!-- <td>₹<?= $quotation->net_payment_price ?></td>
                                    <td><?= $quotation->installment ?></td>
                                    <td><?= date('d D M, Y h:i A', $quotation->created_at) ?></td>
                                    <td><?= $quotation->validity_date ?></td>
                                    <td><?= $quotation->permit_booking_date ?></td>
                                    <td>
                                        <?php
                                        if (isset($quotation->due_quatation)) {
                                            if (!empty($quotation->due_quatation->qr_code_file)) {
                                        ?>
                                                <img src="<?= \Yii::$app->params['s3_endpoint'] . '/' . $quotation->due_quatation->qr_code_file ?>" width="100px" alt="QR Code">
                                        <?php
                                            }
                                            if (!empty($quotation->due_quatation->payment_link)) {
                                                echo Html::a('Payment Link', $quotation->due_quatation->payment_link, ['target' => '_blank', 'class' => 'btn btn-link btn-sm']);
                                            }
                                        }
                                        ?>


                                    </td>



                                </tr>
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div> -->

<!-- <div class="card">
    <div class="card-body">
        <h4>Assign To</h4>
        <ul class="nav nav-tabs" role="tablist">
            <?php foreach ($model->assignOperator as $index => $assignOperator) { ?>
                <li class="nav-item">
                    <a href="<?= Url::toRoute(['partner-lead-chat', 'id' => $model->id, 'safari_operator_id' => $assignOperator->partner->id]) ?>" class="nav-link <?= isset($safari_operator_id) && $assignOperator->partner->id == $safari_operator_id ? 'active' : '' ?>">
                        <?= $assignOperator->partner->business_name ?>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </div>
</div> -->

<!-- <div class="modal fade" id="assignAction" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header flageHeader">
                <h6 class="modal-title fs-5" id="exampleModalLabel">
                    Assign
                </h6>
            </div>

            <div class="modal-body modal_form">
                <div id='modalContent'></div>
            </div>

        </div>
    </div>
</div> -->

<!-- <?php
$script = <<< JS

Handle Assign Button Click
$('.pop-up').on('click', function () {
    $('#assignAction').modal('show')
        .find('#modalContent')
        .load($(this).attr('value'));
});

JS;
$this->registerJs($script);
?>

<style>
    .nav-tabs .nav-link.active {
        color: white !important;
        background-color: #237729 !important;
        border-color: #dee2e6 #dee2e6 #fff;
    }

    .table a {
        color: #237729 !important;
    }
</style> -->




<div class="table-wrapper remove-css mb-4">
    <div class="table-responsive">
        <div class="min-width-table">
            <div id="w0" class="grid-view">
                <table class="table tablecustoms table-striped align-middle w-100">
                    <thead>
                        <tr>
                            <th style="width: 1%;">#</th>
                            <th style="width: 5%;">Name</th>
                            <th style="width: 2%;">Safaris</th>
                            <th style="width: 2%;">Travelers</th>
                            <th style="width: 15%;">User Notes</th>
                            <th style="width: 3%;">Travel Date looking For</th>
                            <th style="width: 3%;">Lead Received Date</th>
                            <th style="width: 10%;">Payment Info</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr data-key="840">
                            <td>1</td>
                            <td> Karan</td>
                            <td>1</td>
                            <td>1</td>
                            <td style="text-align: left;">NOANSWER</td>
                            <td style="text-align: left;">03 Jul, 2025- 15 Jul, 2025</td>
                            <td style="text-align: left;">03 Jul, 2025 01:19 PM</td>
                            <td>
                                <div class="paymentInfoDetail">
                                    <a href="" class="payRece d-inline-block mb-1">Payment Received</a>
                                    <p class="mt-1 mb-1"><span class="bolder_font">Payment Date:</span> 03 Jul, 2025 13:24 PM</p>
                                    <p class="mt-0"><span class="bolder_font">Transaction Id:</span> 01DDG45</p>
                                </div>
                            </td>
                        </tr>

                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
<div class="table-wrapper">
    <div class="breadcrumb-header assignPara justify-content-between align-items-center">
        <div>
            <p class="page-header mb-0">Assign To</p>
        </div>
    </div>
    <div class="assign-tabs">
        <div class="row">
            <div class="col-8">
                <ul class="nav nav-tabs flex-row" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home"
                            type="button" role="tab" aria-controls="home" aria-selected="true">The Eagle
                            Safaris</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
                            type="button" role="tab" aria-controls="profile" aria-selected="false">Ankit Kankane Safaris
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact"
                            type="button" role="tab" aria-controls="contact" aria-selected="false">Rawat Safari</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#con"
                            type="button" role="tab" aria-controls="contact" aria-selected="false">Triline</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#fivcont"
                            type="button" role="tab" aria-controls="contact"
                            aria-selected="false">Swatibansal16290</button>
                    </li>
                </ul>
            </div>
        </div>

        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <div class="d-flex gap-3 mb-4">
                    <div>
  <div class="receivedChat supportReceivedChat mt-0 mb-4">
                        <p>Hi, I am interested in Park: Bandhavgarh Tiger Reserve Safaries: 1 Travelers:1 Stay
                            Category:Forest Rest House Start Date:Jul 4, 2025 End Date:Jul 8, 2025 Notes:jhjjh</p>
                        <div class="recievedTime">
                            <span>2025-06-12 23:04</span>
                        </div>
                    </div>
                      <div class="receivedChat supportReceivedChat mt-0 mb-4">
                        <p>Hi, I am interested in Park: Bandhavgarh Tiger Reserve Safaries: 1 Travelers:1 Stay
                            Category:Forest Rest House Start Date:Jul 4, 2025 End Date:Jul 8, 2025 Notes:jhjjh</p>
                        <div class="recievedTime">
                            <span>2025-06-12 23:04</span>
                        </div>
                    </div>
                      <div class="receivedChat supportReceivedChat mt-0 mb-4">
                        <p>Hi, I am interested in Park: Bandhavgarh Tiger Reserve Safaries: 1 Travelers:1 Stay
                            Category:Forest Rest House Start Date:Jul 4, 2025 End Date:Jul 8, 2025 Notes:jhjjh</p>
                        <div class="recievedTime">
                            <span>2025-06-12 23:04</span>
                        </div>
                    </div>
                    </div>
                  
                    <div class="sendNotificationBtn pb-0 mt-2">
                        <a class="button-created new create " href="" title="Create">Send Notification</a>
                    </div>
                </div>

            </div>

            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">comingsoon!</div>
            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">comingsoon!</div>
            <div class="tab-pane fade" id="con" role="tabpanel" aria-labelledby="contact-tab">comingsoon!</div>
            <div class="tab-pane fade" id="fivcont" role="tabpanel" aria-labelledby="contact-tab">comingsoon!</div>
        </div>
    </div>

</div>