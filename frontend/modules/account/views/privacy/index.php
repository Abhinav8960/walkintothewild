<?php
$this->title = 'Account Settings';

?>

<div class="container mt-5 mb-5">
    <div class="row mb-5">
        <div class="col-md-3">
            <?= $this->render('@frontend/modules/account/views/default/_sidebar', ['active' => 'privacy']); ?>
        </div>
        <div class="col-md-9">
            <div class="card">
                Privacy
            </div>
        </div>
    </div>
</div>