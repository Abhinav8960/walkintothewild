<?php

use yii\helpers\Url;

?>

<div class="nav flex-column nav-pills">
    <a href="<?= Url::toRoute(['/manage']) ?>" class="nav-link mb-2 <?= $active == 'profile' ? 'active' : '' ?>">Overview</a>
    <a href="<?= Url::toRoute(['/manage/park']) ?>" class="nav-link mb-2 <?= $active == 'park' ? 'active' : '' ?>">Safari Park</a>
    <a href="<?= Url::toRoute(['/manage/quote']) ?>" class="nav-link mb-2 <?= $active == 'quote' ? 'active' : '' ?>">Get a Free Quote</a>
    <a href="<?= Url::toRoute(['/manage/review']) ?>" class="nav-link mb-2 <?= $active == 'review' ? 'active' : '' ?>">User Review</a>
    <a href="<?= Url::toRoute(['/manage/follower']) ?>" class="nav-link mb-2 <?= $active == 'follower' ? 'active' : '' ?>">Followers</a>
    <a href="<?= Url::toRoute(['/manage/sharedsafari']) ?>" class="nav-link mb-2 <?= $active == 'sharedsafari' ? 'active' : '' ?>">Shared Safari</a>
    <a href="<?= Url::toRoute(['/manage/package']) ?>" class="nav-link mb-2 <?= $active == 'package' ? 'active' : '' ?>">Packages</a>
    <a href="<?= Url::toRoute(['/manage/article']) ?>" class="nav-link mb-2 <?= $active == 'article' ? 'active' : '' ?>">Articles</a>
    <a href="<?= Url::toRoute(['/manage/user']) ?>" class="nav-link mb-2 <?= $active == 'user' ? 'active' : '' ?>">Users</a>
</div>