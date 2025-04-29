<?php

use common\models\partnerregistration\PartnerRegistration;

?>
<div class="main-sidebar sticky" style="position: fixed; top: 400px; right: 0; width: 300px; z-index: 1030;">
    <div class="card" style="background: #fff; box-shadow: 0 2px 6px rgba(220, 53, 69, 0.3);">
        <div class="card-header text-white fw-bold" style="background-color: #dc3545;">
            Rejecting Reasons
        </div>
        <div class="card-body" style="font-size: 13px; max-height: 400px; overflow-y: auto;">
            <?php
            if ($model->form1_status == PartnerRegistration::FORM_REJECTED) {
                echo '<strong>Legal Entity:</strong> ' . $model->form1_reject_reason . '<br>';
            }
            if ($model->form2_status == PartnerRegistration::FORM_REJECTED) {
                echo '<strong>Registration Proof:</strong> ' . $model->form2_reject_reason . '<br>';
            }
            if ($model->form3_status == PartnerRegistration::FORM_REJECTED) {
                echo '<strong>Business Details:</strong> ' . $model->form3_reject_reason . '<br>';
            }
            if ($model->form4_status == PartnerRegistration::FORM_REJECTED) {
                echo '<strong>Bank Details:</strong> ' . $model->form4_reject_reason . '<br>';
            }
            if ($model->form5_status == PartnerRegistration::FORM_REJECTED) {
                echo '<strong>User KYC:</strong> ' . $model->form5_reject_reason . '<br>';
            }
            ?>
        </div>
    </div>
</div>
