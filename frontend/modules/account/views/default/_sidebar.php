<?php

use yii\helpers\Url;

?>

<div class="nav flex-column nav-pills">
    <h5>Account Settings</h5>
    <a href="<?= Url::toRoute(['/account']) ?>" class="nav-link mb-2 <?= $active == 'profile' ? 'active' : '' ?>">Profile Setting</a>
    <a href="<?= Url::toRoute(['/account/login-info']) ?>" class="nav-link mb-2 <?= $active == 'login' ? 'active' : '' ?>">Login Information</a>
    <a href="<?= Url::toRoute(['/account/notification-setting']) ?>" class="nav-link mb-2 <?= $active == 'notification' ? 'active' : '' ?>">Notification Settings</a>
    <a href="<?= Url::toRoute(['/account/privacy']) ?>" class="nav-link mb-2 <?= $active == 'privacy' ? 'active' : '' ?>">Privacy</a>
    <a href="<?= Url::toRoute(['/account/blocked-member']) ?>" class="nav-link mb-2 <?= $active == 'blocked' ? 'active' : '' ?>">Blocked Members</a>
</div>