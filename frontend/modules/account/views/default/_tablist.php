<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Url;
?>

<ul class="nav nav-tabs mb-4  border-bottom " id="pills-tab" role="tablist">
    <li class="nav-item" role="presentation">
        <a class="nav-link <?= isset($general) ? $general : '' ?>" href="<?= Url::toRoute(['/account/default/index']) ?>">General Information</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link <?= isset($profile_photo) ? $profile_photo : '' ?>" href="<?= Url::toRoute(['/account/default/profile-photo']) ?>">Profile Photo</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link <?= isset($cover_photo) ? $cover_photo : '' ?>" href="<?= Url::toRoute(['/account/default/cover-photo']) ?>">Cover Photo</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link <?= isset($accountType) ? $accountType : '' ?>" href="<?= Url::toRoute(['/account/default/registration-operator']) ?>">Account Type</a>
    </li>
</ul>