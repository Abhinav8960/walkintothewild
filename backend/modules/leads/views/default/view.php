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
    <!-- <h3 class="mt-5">Leads : <?= $model->name ?>, Quotation Received On <?= date('d M, Y h:i A', $model->created_at) ?></h3> -->
    <h3 class="mt-5">Leads </h3>
</div>




<div class="row mb-5  mt-4 itenary_tabs">
    <div class="col-lg-12 col-xl-12 safartabs position-relative">

        <table class="table table-bordered">
            <thead>
                <th>Source</th>
                <th>Safaris</th>
                <th>Travelers</th>
                <th>Accomodation</th>
                <th>Travel Date looking For</th>
                <th>Lead Received Date</th>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <?= $model->sourceLabel ?>
                    </td>
                    <td>
                        <?= !empty($model->safaris) ? $model->safaris : ''; ?>
                    </td>
                    <td>
                        <?= !empty($model->travelers) ? $model->travelers : '' ?>
                    </td>
                    <td>
                        <?= !empty($model->staycatgory) ? $model->staycatgory->title : '' ?>
                    </td>
                    <td>
                        <?php
                        $str =  date('d M, Y', strtotime($model->from_date));
                        if (!empty($model->to_date)) {
                            $str .=  '- ' . date('d M, Y', strtotime($model->to_date));
                        }
                        echo $str;
                        ?>
                    </td>
                    <td>
                        <?= date('d M, Y h:i A', $model->created_at) ?>
                    </td>
                </tr>

            </tbody>
        </table>


    </div>

    <div class="col-md-12">


        <div class="card">
            <div class="card-body">
                <h4>Quatations</h4>

                <table class="table table-responsive table-bordered">
                    <thead>
                        <th>Operator</th>
                        <th>Safaris</th>
                        <th>Travelers</th>
                        <th>Accomodation</th>
                        <th>Travel Date looking For</th>
                        <th>Info</th>
                        <th>Partner selling price</th>
                        <th>Plateform Partner Fees Percentage</th>
                        <th>Plateform Partner Fees</th>
                        <th>Partner net selling price</th>
                        <th>Plateform customer discount</th>
                        <th>Net payment price</th>
                        <th>No of installment</th>
                        <th>Lead Received Date</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        <?php

                        if (count($quotations) > 0) {
                        ?>
                            <?php
                            foreach ($quotations as $quotation) {
                            ?>
                                <tr>
                                    <td>
                                        <?= $quotation->partner->business_name ?>
                                    </td>
                                    <td>
                                        <?= !empty($quotation->safaris) ? $quotation->safaris : ''; ?>
                                    </td>
                                    <td>
                                        <?= !empty($quotation->travelers) ? $quotation->travelers : '' ?>
                                    </td>
                                    <td>
                                        <?= !empty($quotation->staycatgory) ? $quotation->staycatgory->title : '' ?>
                                    </td>
                                    <td>
                                        <?php
                                        $str =  date('d M, Y', strtotime($quotation->start_date));
                                        if (!empty($quotation->end_date)) {
                                            $str .=  '- ' . date('d M, Y', strtotime($quotation->end_date));
                                        }
                                        echo $str;
                                        ?>
                                    </td>
                                    <td>
                                        <?= $quotation->name ?>
                                        <?= $quotation->email ?>
                                        <?= $quotation->phone ?>

                                    </td>

                                    <td>
                                        ₹<?= $quotation->partner_selling_price ?>
                                    </td>
                                    <td>
                                        <?= $quotation->plateform_partner_fees_percentage ?>%
                                    </td>
                                    <td>
                                        ₹<?= $quotation->plateform_partner_fees ?>
                                    </td>
                                    <td>
                                        ₹<?= $quotation->partner_net_selling_price ?>
                                    </td>

                                    <td>
                                        ₹<?= $quotation->plateform_customer_discount ?>
                                    </td>
                                    <td>
                                        ₹<?= $quotation->net_payment_price ?>
                                    </td>
                                    <td>
                                        <?= $quotation->installment ?>
                                    </td>
                                    <td>
                                        <?= date('d D M, Y h:i A', $quotation->created_at) ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ($quotation->is_approved_by_admin == LeadPartnerQuotes::IS_APPROVED_BY_ADMIN_PENDING) {
                                        ?>
                                            <button class="btn btn-success btn-sm approve-btn" data-percentage="<?= $quotation->plateform_partner_fees_percentage ?>" data-id="<?= $quotation->id ?>" data-bs-toggle="modal" data-bs-target="#approveModal">Approve</button>
                                            <button class="btn btn-danger btn-sm disapprove-btn" data-id="<?= $quotation->id ?>" data-bs-toggle="modal" data-bs-target="#disapproveModal">Disapprove</button>

                                        <?php
                                        }
                                        ?>

                                    </td>
                                </tr>
                            <?php
                            }
                            ?>

                        <?php
                        }
                        ?>


                    </tbody>
                </table>

                <div class="card">
                    <div class="card-body">
                        <h4>Assign To</h4>
                        <?php
                        foreach ($model->assignOperator as $assignOperator) {
                        ?>
                            <li>
                                <a target="_blank" href="/operator/safari-operator/index?SafariOperatorSearch[business_name]=<?= $assignOperator->partner->business_name ?>"><?= $assignOperator->partner->business_name ?> </a>

                            <?php
                        }
                            ?>
                            </ul>
                    </div>
                </div>
            </div>
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
                        <div class="mb-3">
                            <label for="payment-url" class="form-label">Payment URL</label>
                            <input type="url" class="form-control" id="payment-url" placeholder="Enter Payment URL" required>

                            <label for="payment-url" class="form-label">Plateform Partner Fees Percentage</label>
                            <input type="number" class="form-control" id="plateform-partner-fees-percentage" placeholder="Enter Plateform partner fees percentage" required>

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
</div>
<?php
$script = <<< JS
// Handle Approve Button Click
$('.approve-btn').on('click', function() {
    var quotationId = $(this).data('id');
    var percentage = $(this).data('percentage'); // Get the percentage value from the button
    $('#approve-quotation-id').val(quotationId); // Set the quotation ID in the modal
    $('#plateform-partner-fees-percentage').val(percentage); // Prepopulate the
});

// Handle Approve Form Submission
$('#approve-form').on('submit', function(e) {
    e.preventDefault();
    var quotationId = $('#approve-quotation-id').val();
    var paymentUrl = $('#payment-url').val();
    var partnerFeesPercentage = $('#plateform-partner-fees-percentage').val();
    var fileInput = $('#approval-file')[0].files[0];

    if (fileInput) {
        // If a file is selected, read it as Base64
        var reader = new FileReader();
        reader.onload = function(e) {
           // Include the MIME type before the Base64 content
           var qr_code_file_base64 = e.target.result; // Full Base64 string with MIME type
            sendApproveRequest(quotationId, paymentUrl, partnerFeesPercentage, qr_code_file_base64);
        };
        reader.readAsDataURL(fileInput); // Read the file as Base64
    } else {
        // If no file is selected, proceed without the file
        sendApproveRequest(quotationId, paymentUrl, partnerFeesPercentage, null);
    }
});

// Function to send the approve request
function sendApproveRequest(quotationId, paymentUrl, partnerFeesPercentage, qr_code_file_base64) {
    $.post('/leads/default/approve', {
        id: quotationId,
        payment_url: paymentUrl,
        plateform_partner_fees_percentage: partnerFeesPercentage,
        qr_code_file_base64: qr_code_file_base64 // Include the Base64 file content if available
    }, function(response) {
        if (response.success) {
            location.reload(); // Reload the page to reflect changes
        } else {
            alert('An error occurred: ' + response.message);
        }
    });

    $('#approveModal').modal('hide'); // Hide the modal
}

// Handle Disapprove Button Click
$('.disapprove-btn').on('click', function() {
    var quotationId = $(this).data('id');
    $('#disapprove-quotation-id').val(quotationId); // Set the quotation ID in the modal
});

// Handle Disapprove Form Submission
$('#disapprove-form').on('submit', function(e) {
    e.preventDefault();
    var quotationId = $('#disapprove-quotation-id').val();
    var reason = $('#disapprove-reason').val();

    // Send POST request to disapprove the quotation
    $.post('/leads/default/disapprove', {id: quotationId, reason: reason}, function(response) {
        if (response.success) {
            // alert('Quotation disapproved successfully.');
            location.reload(); // Reload the page to reflect changes
        } else {
            alert('An error occurred: ' + response.message);
        }
    });

    $('#disapproveModal').modal('hide'); // Hide the modal
});
JS;
$this->registerJs($script);
?>