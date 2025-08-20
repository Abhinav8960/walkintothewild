<?php

use business\assets\AppAsset;
use common\models\GeneralModel;
use common\models\leads\LeadPartnerQuotes;
use yii\helpers\Html;
use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\business\assets\NovaAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
$this->title = 'Leads(' . $model->sourceLabel . ')';
$this->params['title'] = $this->title;

if ($model->status == 1 && $model->source == 2) {
    $this->params['buttons'][] = Html::button('Assign', ['value' => Url::toRoute(['/leads/default/assign', 'id' => $model->id]), 'class' => 'btn btn-info pop-up me-2', 'title' => 'Assign']);
}
if ($model->status == 1) {
    $this->params['buttons'][] = Html::a('Inactive', [Url::toRoute(['/leads/default/inactive', 'id' => $model->id])], ['class' => 'btn btn-orange me-2', 'title' => 'Inactive']);
}
if ($model->status == 0) {

    $this->params['buttons'][] = Html::a('Active', [Url::toRoute(['/leads/default/active', 'id' => $model->id])], ['class' => 'btn btn-orange me-2', 'title' => 'Inactive']);
}
AppAsset::register($this);


?>

<div class="row mb-5 mt-4 itenary_tabs">
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

    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4>Quotations</h4>
                <table class="table table-responsive table-bordered">
                    <thead>
                        <th>Received Date</th>
                        <th>Operator</th>
                        <th>Safaris</th>
                        <th>Travelers</th>
                        <th>Accomodation</th>
                        <th>Travel Date looking For</th>
                        <th>Info</th>
                        <!-- <th>Partner selling price</th>
                        <th>Platform Partner Fees Percentage</th>
                        <th>Platform Partner Fees</th>
                        <th>Partner net selling price</th>
                        <th>Platform customer discount</th> -->
                        <th>Net payment price</th>
                        <th>No of installment</th>
                        <!-- <th>Lead Received Date</th> -->
                        <th>Validity Date</th>
                        <th>Permit Booking Date</th>
                        <th>Payment Link</th>
                    </thead>
                    <tbody>
                        <?php if (count($quotations) > 0) { ?>
                            <?php foreach ($quotations as $quotation) { ?>
                                <tr class="<?= $quotation->is_payment_received == true ? 'bg-warning' : '' ?>">
                                    <td><?= date('d D M, Y h:i A', $quotation->created_at) ?></td>
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
                                    </td>
                                    <!-- <td>₹<?= $quotation->partner_selling_price ?></td>
                                    <td><?= $quotation->plateform_partner_fees_percentage ?>%</td>
                                    <td>₹<?= $quotation->plateform_partner_fees ?></td>
                                    <td>₹<?= $quotation->partner_net_selling_price ?></td>
                                    <td>₹<?= $quotation->plateform_customer_discount ?></td> -->
                                    <td>₹<?= $quotation->net_payment_price ?></td>
                                    <td><?= $quotation->installment ?></td>
                                    <!-- <td><?= date('d D M, Y h:i A', $quotation->created_at) ?></td> -->
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
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h4>Assign To</h4>
        <ul class="nav nav-tabs" role="tablist">
            <?php foreach ($model->assignOperator as $index => $assignOperator) { ?>
                <li class="nav-item">
                    <a href="<?= Url::toRoute(['operator-lead-chat', 'id' => $model->id, 'safari_operator_id' => $assignOperator->partner->id]) ?>" class="nav-link <?= isset($safari_operator_id) && $assignOperator->partner->id == $safari_operator_id ? 'active' : '' ?>">
                        <?= $assignOperator->partner->business_name ?>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>








<div class="modal fade" id="assignAction" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
</div>


<?php
$script = <<< JS

// Handle Assign Button Click
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
</style>