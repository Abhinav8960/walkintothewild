<?php

use yii\helpers\Url;

?>

<?= $this->render('@frontend/modules/account/views/default/_sidebar', ['active' => $active]); ?>

<!-- <div class="itenary_tabs">
    <div class="card account-settingside sidebar_account">
        <div class="nav nav-tabs flex-column nav-pills card-body slider_accountsidebar">
            <a href="<?= Url::toRoute(['/manage']) ?>" class="nav-link mb-2 <?= $active == 'profile' ? 'active' : '' ?>">Overview</a>
            <a href="<?= Url::toRoute(['/manage/sharedsafari']) ?>" class="nav-link mb-2 <?= $active == 'sharedsafari' ? 'active' : '' ?>">Shared Safaris</a>
            <a href="<?= Url::toRoute(['/manage/package']) ?>" class="nav-link mb-2 <?= $active == 'package' ? 'active' : '' ?>">Packages</a> -->
            <!-- <a href="<?= Url::toRoute(['/manage/article']) ?>" class="nav-link mb-2 <?= $active == 'article' ? 'active' : '' ?>">Articles</a> -->
            <!-- <a href="<?= Url::toRoute(['/manage/follower']) ?>" class="nav-link mb-2 <?= $active == 'follower' ? 'active' : '' ?>">Followers</a> -->
            <!-- <a href="<?= Url::toRoute(['/manage/review']) ?>" class="nav-link mb-2 <?= $active == 'review' ? 'active' : '' ?>">Reviews</a> -->
            <!-- <a href="<?= Url::toRoute(['/manage/quote']) ?>" class="nav-link mb-2 <?= $active == 'quote' ? 'active' : '' ?>">Get a Free Quote</a>
        <a href="<?= Url::toRoute(['/manage/park']) ?>" class="nav-link mb-2 <?= $active == 'park' ? 'active' : '' ?>">My Safari Parks</a> -->
            <!-- <a href="<?= Url::toRoute(['/manage/user']) ?>" class="nav-link mb-2 <?= $active == 'user' ? 'active' : '' ?>">Users</a> -->
        <!-- </div>
    </div>
</div> -->