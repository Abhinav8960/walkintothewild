<?php
$this->title = 'Account Settings';

?>

<div class="container mt-5">
    <div class="row margin_bottomfooter">
    <div class="col-12">
        <h6 class="fs-3 fw-bold mb-4">Account Settings</h6>
        </div>
        <div class="col-md-3">
            <?= $this->render('@frontend/modules/account/views/default/_sidebar', ['active' => 'login']); ?>
        </div>
        <div class="col-md-9">
            <div class="card account-settingside" style="min-height:500px">
                <div class="card-body p-4">
                <h6 class="fs-5 fw-bold mb-3">  Login Information</h6>
                </div>
   
            </div>
        </div>
    </div>
</div>