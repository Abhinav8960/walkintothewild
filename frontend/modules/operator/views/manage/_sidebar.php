<?php

use yii\helpers\Url;

?>

<div class="nav flex-column nav-pills">
    <a href="<?= Url::toRoute(['/operator/manage/index']) ?>" class="nav-link mb-2 <?= $active == 'profile' ? 'active' : '' ?>">Overview</a>
    <a href="<?= Url::toRoute(['/operator/manage/park']) ?>" class="nav-link mb-2 <?= $active == 'park' ? 'active' : '' ?>">Safari Park</a>
    <a href="<?= Url::toRoute(['/account/login-info']) ?>" class="nav-link mb-2 <?= $active == 'login' ? 'active' : '' ?>">Get a Free Quote</a>
    <a href="<?= Url::toRoute(['/account/notification-setting']) ?>" class="nav-link mb-2 <?= $active == 'notification' ? 'active' : '' ?>">User Review</a>
    <a href="<?= Url::toRoute(['/account/privacy']) ?>" class="nav-link mb-2 <?= $active == 'privacy' ? 'active' : '' ?>">Followers</a>
    <a href="<?= Url::toRoute(['/account/blocked-member']) ?>" class="nav-link mb-2 <?= $active == 'blocked' ? 'active' : '' ?>">Shared Safari</a>
    <a href="<?= Url::toRoute(['/account/blocked-member']) ?>" class="nav-link mb-2 <?= $active == 'blocked' ? 'active' : '' ?>">Packages</a>
</div>