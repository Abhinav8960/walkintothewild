<?php
$this->title = 'Account Settings';

?>

<div class="container mt-5 mb-5">
    <div class="row mb-5">
        <div class="col-md-3">
            <?= $this->render('@frontend/modules/account/views/default/_sidebar', ['active' => 'notification']); ?>
        </div>
        <div class="col-md-9">
            <div class="card">
                Notification Settings
            </div>
        </div>
    </div>
</div>