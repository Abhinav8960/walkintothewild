<?php

use yii\helpers\Url;

?>

<div class="account-settingside">
<div class="nav flex-column nav-pills">
    <a href="<?= Url::toRoute(['/account']) ?>" class="nav-link mb-2 <?= $active == 'profile' ? 'active' : '' ?>"><i class="fa-solid fa-user"></i> Profile Setting</a>
    <a href="<?= Url::toRoute(['/account/login-info']) ?>" class="nav-link mb-2 <?= $active == 'login' ? 'active' : '' ?>"><i class="fa-solid fa-right-to-bracket"></i> Login Information</a>
    <a href="<?= Url::toRoute(['/account/notification-setting']) ?>" class="nav-link mb-2 <?= $active == 'notification' ? 'active' : '' ?>">Notification Settings</a>
    <a href="<?= Url::toRoute(['/account/privacy']) ?>" class="nav-link mb-2 <?= $active == 'privacy' ? 'active' : '' ?>">Privacy</a>
    <a href="<?= Url::toRoute(['/account/blocked-member']) ?>" class="nav-link mb-2 <?= $active == 'blocked' ? 'active' : '' ?>">Blocked Members</a>
</div>
</div>
