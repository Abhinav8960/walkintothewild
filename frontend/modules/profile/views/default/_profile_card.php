<?php

use common\models\UserFollow;
use yii\helpers\Url;

?>


<div class="card_profile card h-100 position-relative">
    <div class="dots-blockbox">
        <i class="fa-solid fa-ellipsis"></i>
        <div class="box_dropdown">

            <a href="<?= Url::toRoute(['/profile/default/index', 'user_handle' => $user->user_handle]) ?>" class="">View Profile</a>
            <?php if (Yii::$app->user->id != $user->id) { ?>
                <a href="<?= Url::toRoute(['/profile/search/blocked', 'user_handle' => $user->user_handle]) ?>" class="">Block</a>
            <?php } ?>
        </div>
    </div>

    <!-- <div class="card-up cover_profile">
            <img src="<?= $user->cover_image <> '' ?  $user->coverimage : $this->params['baseurl'] . '/img/banner-share.png' ?>" alt="" style="width: 100%; height: 130px;">
        </div> -->
    <div class="profileDetails  text-center">
        <a href="<?= Url::toRoute(['/profile/default/index', 'user_handle' => $user->user_handle]) ?>">
            <div class=" mx-auto white">
                <img src="<?= $user->profileimage ? $user->profileimage : $this->params['baseurl'] . '/img/user.png' ?>" class="rounded-circle img-fluid" alt="profile-image">

            </div>
            <div class="card-body text-center  pt-2">
                <h6 class="fs-4 fw-bold usename"><?= $user->name ?></h6>
                <h6 class="fs-6 joint-text">Joined <?= date('M Y', $user->created_at) ?></h6>
                <div class="followres-count pt-3">
                    <h6 class="folloerwstext"><?= $user->getUserfollowers()->where(['status' => 1])->count(); ?> Followers</h6>
                </div>
            </div>
        </a>
        <div class="followunfollowbtn border-top ">
            <?php
            if (Yii::$app->user->identity) {
                if (Yii::$app->user->identity->id == $profile_user->id) { ?>
                    <div class="row">
                        <div class="col-6 divider">
                            <div class="folollowBtns ">
                                <?php
                                $follower = UserFollow::find()->where(['follow_user_id' => $user->id, 'user_id' => $profile_user->id, 'status' => 1])->one();
                                if ($follower) { ?>
                                    <a href="<?= Url::toRoute(['/profile/default/unfollow', 'user_handle' => $user->user_handle]) ?>" data-method="POST">Unfollow</a>
                                <?php  } else { ?>
                                    <a href="<?= Url::toRoute(['/profile/default/follow', 'user_handle' => $user->user_handle]) ?>" data-method="POST">Follow</a>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="massegses">
                                <a href="<?= Url::toRoute(['/chat/default/message', 'user_handle' => $user->user_handle]) ?>">Message</a>
                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="row">
                        <div class="col-12 divider">
                            <div class="massegses">
                                <a href="<?= Url::toRoute(['/chat/default/message', 'user_handle' => $user->user_handle]) ?>">Message</a>
                            </div>
                        </div>
                    </div>
            <?php }
            } ?>
        </div>
    </div>

</div>