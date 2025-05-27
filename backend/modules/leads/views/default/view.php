<?php

use business\assets\AppAsset;
use common\models\GeneralModel;
use common\models\leads\LeadPartnerQuotes;
use yii\helpers\Html;
use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\business\assets\NovaAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
AppAsset::register($this);
$this->title = 'Leads : ' . $model->name . ', ' . date('d M, Y h:i A', $model->created_at);

?>

<div class="d-flex justify-content-between align-items-center mt-5">
    <h3 class="mt-5">Leads (<?= $model->sourceLabel ?>)</h3>
</div>

<div class="row mb-5 mt-4 itenary_tabs">
    <div class="col-lg-12 col-xl-12 safartabs position-relative">
        <table class="table table-bordered">
            <thead>
                <th>Name</th>
                <th>Safaris</th>
                <th>Travelers</th>
                <th>Accomodation</th>
                <th>Travel Date looking For</th>
                <th>Lead Received Date</th>
            </thead>
            <tbody>
                <tr>
                    <td><?= $model->displayLabel ?></td>
                    <td><?= !empty($model->safaris) ? $model->safaris : ''; ?></td>
                    <td><?= !empty($model->travelers) ? $model->travelers : '' ?></td>
                    <td><?= !empty($model->staycatgory) ? $model->staycatgory->title : '' ?></td>
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
                        <th>Operator</th>
                        <th>Safaris</th>
                        <th>Travelers</th>
                        <th>Accomodation</th>
                        <th>Travel Date looking For</th>
                        <th>Info</th>
                        <th>Partner selling price</th>
                        <th>Platform Partner Fees Percentage</th>
                        <th>Platform Partner Fees</th>
                        <th>Partner net selling price</th>
                        <th>Platform customer discount</th>
                        <th>Net payment price</th>
                        <th>No of installment</th>
                        <th>Lead Received Date</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        <?php if (count($quotations) > 0) { ?>
                            <?php foreach ($quotations as $quotation) { ?>
                                <tr>
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
                                    <td>₹<?= $quotation->partner_selling_price ?></td>
                                    <td><?= $quotation->plateform_partner_fees_percentage ?>%</td>
                                    <td>₹<?= $quotation->plateform_partner_fees ?></td>
                                    <td>₹<?= $quotation->partner_net_selling_price ?></td>
                                    <td>₹<?= $quotation->plateform_customer_discount ?></td>
                                    <td>₹<?= $quotation->net_payment_price ?></td>
                                    <td><?= $quotation->installment ?></td>
                                    <td><?= date('d D M, Y h:i A', $quotation->created_at) ?></td>
                                    <td>
                                        <?php if ($quotation->is_approved_by_admin == LeadPartnerQuotes::IS_APPROVED_BY_ADMIN_PENDING) { ?>
                                            <button class="btn btn-success btn-sm approve-btn" data-partner-selling-price="<?= $quotation->partner_selling_price ?>" data-percentage="<?= $quotation->plateform_partner_fees_percentage ?>" data-id="<?= $quotation->id ?>" data-bs-toggle="modal" data-bs-target="#approveModal">Approve</button>
                                            <button class="btn btn-danger btn-sm disapprove-btn" data-id="<?= $quotation->id ?>" data-bs-toggle="modal" data-bs-target="#disapproveModal">Disapprove</button>
                                        <?php } ?>
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

<!-- Approve Modal -->
<div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="approveModalLabel">Approve Quotation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="approve-form">
                    <input type="hidden" id="approve-quotation-id">
                    <input type="hidden" id="partner-selling-price" value="0">
                    <div class="mb-3">
                        <label for="payment-url" class="form-label">Payment URL</label>
                        <input type="url" class="form-control" id="payment-url" placeholder="Enter Payment URL" required>
                        <label for="plateform-partner-fees-percentage" class="form-label">Platform Partner Fees Percentage</label>
                        <input type="number" class="form-control" id="plateform-partner-fees-percentage" placeholder="Enter Platform partner fees percentage" required>
                        <small id="net-payment-price-hint" class="form-text text-muted"></small>
                        <label for="approval-file" class="form-label">Upload QR Code File</label>
                        <input type="file" class="form-control" id="approval-file" accept=".jpg,.png">
                    </div>
                    <button type="submit" class="btn btn-success">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Disapprove Modal -->
<div class="modal fade" id="disapproveModal" tabindex="-1" aria-labelledby="disapproveModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="disapproveModalLabel">Disapprove Quotation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="disapprove-form">
                    <input type="hidden" id="disapprove-quotation-id">
                    <div class="mb-3">
                        <label for="disapprove-reason" class="form-label">Reason for Disapproval</label>
                        <textarea class="form-control" id="disapprove-reason" rows="3" placeholder="Enter reason for disapproval" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-danger">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
$script = <<< JS
// Handle Approve Button Click
$('.approve-btn').on('click', function() {
    var quotationId = $(this).data('id');
    var percentage = $(this).data('percentage');
    var partnerSellingPrice = $(this).data('partner-selling-price');
    $('#approve-quotation-id').val(quotationId);
    $('#plateform-partner-fees-percentage').val(percentage);
    $('#partner-selling-price').val(partnerSellingPrice);
    updateNetPaymentPriceHint();
});

// Update net payment price hint dynamically on percentage change
$('#plateform-partner-fees-percentage').on('input', function() {
    updateNetPaymentPriceHint();
});

function updateNetPaymentPriceHint() {
    var partnerSellingPrice = parseFloat($('#partner-selling-price').val()) || 0;
    var percentage = parseFloat($('#plateform-partner-fees-percentage').val()) || 0;
    var partnerFees = (partnerSellingPrice * percentage) / 100;
    var netPaymentPrice = partnerSellingPrice + partnerFees;
    $('#net-payment-price-hint').text('Net Payment Price: ₹' + netPaymentPrice.toFixed(2));
}

// Handle Approve Form Submission
$('#approve-form').on('submit', function(e) {
    e.preventDefault(); // Prevent default form submission

    // Get form values
    var quotationId = $('#approve-quotation-id').val();
    var paymentUrl = $('#payment-url').val();
    var partnerFeesPercentage = $('#plateform-partner-fees-percentage').val();
    var qrCodeFile = $('#approval-file').prop('files')[0];

    // Call sendApproveRequest function
    sendApproveRequest(quotationId, paymentUrl, partnerFeesPercentage, qrCodeFile);
});

// Function to send the approve request
function sendApproveRequest(quotationId, paymentUrl, partnerFeesPercentage, qrCodeFile) {
    var formData = new FormData();
    formData.append('id', quotationId);
    formData.append('payment_url', paymentUrl);
    formData.append('plateform_partner_fees_percentage', partnerFeesPercentage);
    if (qrCodeFile) {
        formData.append('qr_code_file', qrCodeFile);
    }

    $.ajax({
        url: '/leads/default/approve',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response.success) {
                location.reload();
            } else {
                alert('An error occurred: ' + response.message);
            }
        },
        error: function() {
            alert('An error occurred while processing the request.');
        }
    });

    $('#approveModal').modal('hide');
}

// Handle Disapprove Button Click
$('.disapprove-btn').on('click', function() {
    var quotationId = $(this).data('id');
    $('#disapprove-quotation-id').val(quotationId);
});

// Handle Disapprove Form Submission
$('#disapprove-form').on('submit', function(e) {
    e.preventDefault();
    var quotationId = $('#disapprove-quotation-id').val();
    var reason = $('#disapprove-reason').val();
    $.post('/leads/default/disapprove', {id: quotationId, reason: reason}, function(response) {
        if (response.success) {
            location.reload();
        } else {
            alert('An error occurred: ' + response.message);
        }
    });
    $('#disapproveModal').modal('hide');
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