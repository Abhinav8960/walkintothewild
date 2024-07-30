<?php
$this->title = 'Account Settings';

?>

<div class="container mt-5 ">
    <div class="row margin_bottomfooter">
    <div class="col-12 d-flex align-items-center justify-content-between mb-4">
            <h6 class="fs-3 fw-bold ">Account Settings</h6>
            <a href="" class="btn btn-info bg-blues py-2">View Profile</a>
        </div>
        <div class="col-md-3">
            <?= $this->render('@frontend/modules/account/views/default/_sidebar', ['active' => 'privacy']); ?>
        </div>
        <div class="col-md-9">
        <div class="card account-settingside" style="min-height:500px">
                <div class="card-body p-4">
                <h6 class="fs-5 fw-bold mb-3">  Privacy</h6>
                </div>
   
            </div>
        </div>
       
    </div>
</div>