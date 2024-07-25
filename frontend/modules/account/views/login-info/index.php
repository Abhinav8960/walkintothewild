<?php
$this->title = 'Account Settings';

?>

<div class="container mt-5 mb-5">
    <div class="row mb-5">
    <div class="col-12">
        <h6 class="fs-3 fw-bold mb-4">Account Settings</h6>
        </div>
        <div class="col-md-3">
            <?= $this->render('@frontend/modules/account/views/default/_sidebar', ['active' => 'login']); ?>
        </div>
        <div class="col-md-9">
            <div class="card account-settingside" style="min-height:500px">
                <div class="card-body">
                <h6 class="fs-5 fw-bold">  Login Information</h6>
                </div>
   
            </div>
        </div>
    </div>
</div>