<?php

use yii\helpers\Url;

?>

<a href="<?= Url::toRoute(['/profile/default/index', 'user_handle' => $user->user_handle]) ?>">

    <div class="card_profile card h-100 position-relative">
        <div class="card-up cover_profile">
            <img src="<?= $user->cover_image <> '' ?  $user->coverimage : $this->params['baseurl'] . '/img/banner-share.png' ?>" alt="" style="width: 100%; height: 130px;">
        </div>
        <div class="profileDetails margin_n5 text-center">
            <div class=" mx-auto white">
                <img src="<?= $user->profileimage ? $user->profileimage : $this->params['baseurl'] . '/img/user.png' ?>" class="rounded-circle img-fluid" alt="profile-image">
            </div>
            <div class="card-body text-center  pb-4 pt-1">
                <h6 class="fs-4 fw-bold"><?= $user->name ?></h6>
                <h6 class="card-title pb-3"><?= $user->userhandle ?></h4>  
                    <?php if (Yii::$app->user->id != $user->id) { ?>
                        <div class="block_wrap">
                        <a href="<?= Url::toRoute(['/profile/search/blocked', 'user_handle' => $user->user_handle]) ?>" class="follow_massge text-center mt-sm-0 mt-2">Blocked</a>
                        </div>
                     
                    <?php } ?>
            </div>
        </div>
    </div>

</a>