<?php

use yii\helpers\Url;

?>
<div class="itenary_tabs">
<div class="card account-settingside sidebar_account ">
    <div class="nav nav-tabs flex-column nav-pills card-body slider_accountsidebar ">
        <a href="<?= Url::toRoute(['/account']) ?>" class="nav-link mb-2 <?= $active == 'profile' ? 'active' : '' ?>"><i class="fa-solid fa-user me-2"></i> Profile Settings</a><!--
        <a href="<?= Url::toRoute(['/account/login-info']) ?>" class="nav-link mb-2 <?= $active == 'login' ? 'active' : '' ?>"><i class="fa-solid fa-gear me-2"></i> Login Information</a> -->
        <!-- <a href="<?= Url::toRoute(['/account/notification-setting']) ?>" class="nav-link mb-2 <?= $active == 'notification' ? 'active' : '' ?>"><i class="fa-solid fa-bell me-2"></i> Notification Settings</a> -->
        <a href="<?= Url::toRoute(['/account/privacy']) ?>" class="nav-link mb-2 <?= $active == 'privacy' ? 'active' : '' ?>"><i class="fa-solid fa-lock me-2"></i> Privacy</a>
        <a href="<?= Url::toRoute(['/account/blocked-member']) ?>" class="nav-link mb-2 <?= $active == 'blocked' ? 'active' : '' ?>"><i class="fa-solid fa-user-lock me-2"></i> Blocked Members</a>
    </div>
</div>
</div>


