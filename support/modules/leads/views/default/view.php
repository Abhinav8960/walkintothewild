<?php

use common\models\leads\LeadPartnerQuotes;
use common\models\GeneralModel;
use support\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\support\assets\NovaAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
$this->title = 'Leads(' . $model->sourceLabel . ')';
$this->params['title'] = $this->title;

AppAsset::register($this);
?>

<?= $this->render('_userdetail', ['model' => $model]) ?>

<div>
    <p class="page-header">Quotation</p>
</div>
<div class="table-wrapper remove-css mb-4">
    <div class="table-responsive">
        <div class="min-width-table">
            <div id="w0" class="table-responsive">
                <table class="table tablecustoms table-striped align-middle w-100">
                    <thead>
                        <tr>
                            <th>Recieved Date</th>
                            <th>Operator</th>
                            <th>Safaris</th>
                            <th>Travelers</th>
                            <th>Accomodation</th>
                            <th>Travel Date looking For</th>
                            <th>Info</th>
                            <th>Net payment price</th>
                            <th>No of installment</th>
                            <th>Validity Date</th>
                            <th>Permit Booking Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($quotations) > 0) { ?>
                            <?php foreach ($quotations as $quotation) { ?>
                                <tr>
                                    <td><?= date('d M Y, h:i A', $quotation->created_at) ?></td>
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
                                    <td>₹<?= $quotation->net_payment_price ?></td>
                                    <td><?= $quotation->installment ?></td>
                                    <td><?= $quotation->validity_date ?></td>
                                    <td><?= $quotation->permit_booking_date ?></td>
                                </tr>
                            <?php } ?>
                        <?php } ?>

                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

<div class="d-flex justify-content-between">
    <p class="page-header">Call Logs</p>
    <a href="<?= Url::toRoute(['makeacall', 'id' => $model->id]) ?>" class="text-end btn btn-success" data-confirm="Are You Sure You want to make a New Call With this Customer?"><i class="fa fa-phone"></i> Make a New Call</a>
</div>
<div class="table-wrapper remove-css mb-4">
    <div class="table-responsive">
        <div class="min-width-table">
            <div id="w0" class="table-responsive">
                <table class="table tablecustoms table-striped align-middle w-100">
                    <thead>
                        <tr>
                            <th>Caller Name</th>
                            <th>Call Date</th>
                            <th>Talk Duration</th>
                            <th>API Call Status</th>
                            <th>Call Status</th>
                            <!-- <th>View Recording</th> -->
                            <th>Last Note</th>
                            <th>Update Note</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($calllogs) { ?>
                            <?php foreach ($calllogs as $call_log) { ?>
                                <tr>
                                    <td><?= $call_log->callerUser2->name ?></td>
                                    <td><?= date('d M Y, h:i A', $call_log->created_at) ?></td>
                                    <td><?= $call_log->talk_duration ?></td>
                                    <td><?= $call_log->call_status ?></td>
                                    <td><?= $call_log->status == 1 ? 'Dialed' : 'Failed' ?></td>
                                    <!-- <td></td> -->
                                    <td><?= $call_log->support_user_note ?></td>
                                    <td><?= Html::a('<i class="fa fa-edit"></i> Update', ['updatecall', 'id' => $model->id, 'call_log_id' => $call_log->id], ['class' => 'btn btn-info btn-sm']) ?></td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
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

    <?php
    if (count($model->assignOperator) > 0) {
    ?>

        <div class="assign-tabs">

            <ul class="nav nav-tabs flex-row flex-wrap" id="myTab" role="tablist">
                <?php foreach ($model->assignOperator as $index => $assignOperator) { ?>
                    <li class="nav-item" role="presentation">
                        <a href="<?= Url::toRoute(['partner-lead-chat', 'id' => $model->id, 'safari_operator_id' => $assignOperator->partner->id]) ?>" class="nav-link <?= isset($safari_operator_model->id) && $assignOperator->partner->id == $safari_operator_model->id ? 'active' : '' ?>">
                            <?= $assignOperator->partner->business_name ?></a>
                    </li>
                <?php } ?>
            </ul>

            <?php
            if (isset($chat)) {
                echo $this->render('_chatbox', ['model' => $model, 'quotations' => $quotations, 'safari_operator_id' => $safari_operator_model->id, 'chat' => $chat, 'safari_operator_model' => $safari_operator_model]);
            }
            ?>
        </div>
    <?php
    }
    ?>
</div>