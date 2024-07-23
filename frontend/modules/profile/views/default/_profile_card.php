<?php

use yii\helpers\Url;

?>

<a href="<?= Url::toRoute(['/profile/default/index', 'user_handle' => $user->user_handle]) ?>">
    <div class="card testimonial-card mt-2 mb-3">
        <div class="card-up">
            <img src="<?= $user->cover_image <> '' ?  $user->coverimage : $this->params['baseurl'] . '/img/banner-share.png' ?>" alt="" class="img-fluid" style="width: 500px; height: 200px;">
        </div>
        <div class=" mx-auto white">
            <img src="<?= $user->profileimage ? $user->profileimage : $this->params['baseurl'] . '/img/user.png' ?>" class="rounded-circle img-fluid" alt="profile-image">
        </div>
        <div class="card-body text-center">
            <h4 class="card-title font-weight-bold"><?= $user->name ?></h4>
            <h6 class="card-title"><?= $user->userhandle ?></h4>
                <hr>
                <a href="<?= Url::toRoute(['/profile/search/blocked', 'user_handle' => $user->user_handle]) ?>" class="join_btn text-center mt-sm-0 mt-2">Blocked</a>
        </div>

    </div>
</a>