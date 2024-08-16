<?php

use yii\helpers\Url;
?>
<ul class="nav nav-tabs border-bottom p" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <a href="<?= Url::toRoute(['/manage/sharedsafari/view', 'slug' => $share_safari->slug]) ?>" class="nav-link <?= isset($interested_active) ? $interested_active : '' ?>" id="home-tab">Interested</a>
    </li>
    <li class="nav-item" role="presentation">
        <a href="<?= Url::toRoute(['/manage/sharedsafari/comment', 'slug' => $share_safari->slug]) ?>" class="nav-link <?= isset($comment_active) ? $comment_active : '' ?>" id="profile-tab">Comment</a>
    </li>
</ul>