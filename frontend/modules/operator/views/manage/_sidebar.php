<?php

use yii\helpers\Url;

?>

<div class="nav flex-column nav-pills">
    <a href="<?= Url::toRoute(['/operator/manage/index']) ?>" class="nav-link mb-2 <?= $active == 'profile' ? 'active' : '' ?>">Overview</a>
    <a href="<?= Url::toRoute(['/operator/manage/park']) ?>" class="nav-link mb-2 <?= $active == 'park' ? 'active' : '' ?>">Safari Park</a>
    <a href="<?= Url::toRoute(['/operator/manage/quote']) ?>" class="nav-link mb-2 <?= $active == 'quote' ? 'active' : '' ?>">Get a Free Quote</a>
    <a href="<?= Url::toRoute(['/operator/manage/review']) ?>" class="nav-link mb-2 <?= $active == 'review' ? 'active' : '' ?>">User Review</a>
    <a href="<?= Url::toRoute(['/operator/manage/follower']) ?>" class="nav-link mb-2 <?= $active == 'follower' ? 'active' : '' ?>">Followers</a>
    <a href="<?= Url::toRoute(['/operator/manage/sharedsafari']) ?>" class="nav-link mb-2 <?= $active == 'sharedsafari' ? 'active' : '' ?>">Shared Safari</a>
    <a href="<?= Url::toRoute(['/operator/manage/package']) ?>" class="nav-link mb-2 <?= $active == 'package' ? 'active' : '' ?>">Packages</a>
</div>