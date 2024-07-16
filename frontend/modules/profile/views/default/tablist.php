<?php

use common\models\UserFollow;
use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;


$this->title = 'Profile';
$this->params['title'] = $this->title;
?>

<div class="card overflow-hidden">
    <div class="card-body p-0">
        <img src="<?= $user->cover_image <> '' ?  $user->coverimage : $this->params['baseurl'] . '/img/user.png' ?>" alt="" class="img-fluid" style="width: 1500px; height: 300px;">
        <div class="row align-items-center">
            <div class="mt-n5">
                <div class="d-flex align-items-center justify-content-center mb-2">
                    <div class="linear-gradient d-flex align-items-center justify-content-center rounded-circle" style="width: 110px; height: 110px;" ;="">
                        <div class="border border-4 border-white d-flex align-items-center justify-content-center rounded-circle overflow-hidden" style="width: 100px; height: 100px;" ;="">
                            <img src="<?= $user->profile_image <> '' ?  $user->profileimage : $this->params['baseurl'] . '/img/user.png' ?>" alt="" class="w-100 h-100">
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <h5 class="fs-5 mb-0 fw-semibold"><?= $user->name ?></h5>
                </div>
                <div class="text-center">
                    <h6 class="mb-0"><?= $user->userhandle ?></h6>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 order-lg-1 order-1">
                <div class="d-flex align-items-center m-1">
                    <p class="mb-1 m-4"><?= UserFollow::find()->where(['user_id' => $user->id, 'status' => 1])->count(); ?>Followers</p>
                    <p class="mb-1 m-4"><?= UserFollow::find()->where(['follow_user_id' => $user->id, 'status' => 1])->count(); ?>Following</p>
                </div>
            </div>

            <div class="col-lg-4 order-lg-2 order-2 mx-auto ">
                <div class="d-flex align-items-center m-1 mx-auto align-items-center justify-content-center">
                    <?php if (Yii::$app->user->identity->id != $user->id) {
                        if (UserFollow::find()->where(['follow_user_id' => Yii::$app->user->identity->id, 'user_id' => $user->id, 'status' => '1'])->one()) { ?>
                            <a href="<?= Url::toRoute(['/profile/default/unfollow', 'id' =>  $user->id]) ?>" class="btn btn-light m-2">Unfollow</a>
                        <?php } else { ?>
                            <a href="<?= Url::toRoute(['/profile/default/follow', 'id' =>  $user->id]) ?>" class="btn btn-light m-2">Follow</a>
                        <?php } ?>
                    <?php } ?>
                    <a href="#" class="btn btn-light m-2">Message</a>
                </div>
            </div>

            <div class="col-lg-4 order-lg-3 order-3">
                <div class="sociel_icons ps-3 ">
                    <?php
                    $shared_url = urlencode(Url::to('', true));
                    ?>
                    <ul>
                        <li><a href="https://www.facebook.com/sharer/sharer.php?u=<?= $shared_url ?>" target="_blank" class="iconSize"><i class="fa-brands fa-facebook-f"></i></a>
                        </li>
                        <li><a href="https://wa.me/?text=<?= $shared_url ?>" target="_blank" class="iconSize"><i class="fa-brands fa-whatsapp"></i></a>
                        </li>
                        <li><a href="https://twitter.com/intent/tweet?url=<?= $shared_url ?>" target="_blank" class="iconSize"><i class="fa-brands fa-x-twitter"></i></a>
                        </li>
                        <li><a href="https://www.instagram.com/?url=<?= urlencode($shared_url) ?>" target="_blank" class="iconSize"><i class="fa-brands fa-instagram"></i></a>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
        <hr>
        <ul class="nav nav-pills mb-2 ms-2">
            <li><a href="/profile/default" class="nav-link <?= isset($profile) ? $profile : '' ?>">Profile</a></li>
            <li><a href="/profile/activity" class=" nav-link <?= isset($activity) ? $activity : '' ?>">Activity</a></li>
            <li><a href="/profile/contribution" class="nav-link <?= isset($contribution) ? $contribution : '' ?>">Contribution</a></li>
            <li><a href="/profile/photo" class="nav-link <?= isset($photo) ? $photo : '' ?>">Photo</a></li>
            <li><a href="/profile/article" class="nav-link <?= isset($article) ? $article : '' ?>">Article</a></li>
            <li><a href="/profile/share-safari" class="nav-link <?= isset($share_safari) ? $share_safari : '' ?>">Share Safari</a></li>
        </ul>
    </div>
</div>