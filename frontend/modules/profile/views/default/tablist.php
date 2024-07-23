<?php

use yii\helpers\Url;
use common\models\UserFollow;
use common\models\registration\SafariOperatorRequest;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
?>

<div class="card overflow-hidden mt-2">
    <div class="card-body p-0">
        <img src="<?= $user->cover_image <> '' ?  $user->coverimage : $this->params['baseurl'] . '/img/banner-share.png' ?>" alt="" class="img-fluid" style="width: 1500px; height: 300px;">
        <div class="row align-items-center">
            <div class="mt-n5">
                <div class="d-flex align-items-center justify-content-center mb-2">
                    <div class="linear-gradient d-flex align-items-center justify-content-center rounded-circle" style="width: 110px; height: 110px;" ;="">
                        <div class="border border-4 border-white d-flex align-items-center justify-content-center rounded-circle overflow-hidden" style="width: 100px; height: 100px;" ;="">
                            <img src="<?= $user->profileimage <> '' ?  $user->profileimage : $this->params['baseurl'] . '/img/user.png' ?>" alt="" class="w-100 h-100">
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <h5 class="fs-5 mb-0 fw-semibold"><?= $user->name ?></h5>
                </div>
                <div class="text-center">
                    <h6 class="mb-0"><?= $user->userhandle ?></h6>
                </div>
                <?php if ($user->user_bio <> '') { ?>
                    <div class="text-center">
                        <p class="mb-0"><?= $user->user_bio ?></p>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 ">
                <div class="d-flex align-items-center m-1">
                    <p class="mb-1 m-4"><a href="<?= Url::toRoute(['/profile/default/follower', 'user_handle' => $user->user_handle]) ?>"> <?= $user->getUserfollowers()->where(['status' => 1])->count(); ?> Followers</a></p>
                    <p class="mb-1 m-4"><a href="<?= Url::toRoute(['/profile/default/following', 'user_handle' => $user->user_handle]) ?>"> <?= $user->getUserfollowings()->where(['status' => 1])->count(); ?> Following</a></p>
                </div>
            </div>

            <div class="col-lg-4 ">
                <div class="d-flex align-items-center m-1 mx-auto align-items-center justify-content-center">
                    <?php if (Yii::$app->user->identity && Yii::$app->user->identity->id != $user->id) {
                        if (UserFollow::find()->where(['user_id' => Yii::$app->user->identity->id, 'follow_user_id' => $user->id, 'status' => '1'])->one()) { ?>
                            <a href="<?= Url::toRoute(['/profile/default/unfollow', 'id' =>  $user->id]) ?>" class="btn btn-light m-2">Unfollow</a>
                        <?php } else { ?>
                            <a href="<?= Url::toRoute(['/profile/default/follow', 'id' =>  $user->id]) ?>" class="btn btn-light m-2">Follow</a>
                        <?php } ?>
                        <a href="#" class="btn btn-light m-2">Message</a>
                    <?php } else { ?>
                        <a href="<?= Url::toRoute(['/account', 'id' =>  $user->id]) ?>" class="btn btn-light m-2"><i class="fa fa-edit"></i> Edit Profile</a>
                    <?php } ?>

                </div>
            </div>

            <div class="col-lg-4">
                <div class="sociel_icons ps-3">
                    <ul>
                        <?php if ($user->facebook_url) { ?>
                            <li><a href="<?= $user->facebook_url; ?>" target="_blank" class="iconSize"><i class="fa-brands fa-facebook-f"></i></a>
                            </li>
                        <?php } ?>
                        <?php if ($user->whatsapp_url) { ?>
                            <li><a href="<?= $user->whatsapp_url; ?>" target="_blank" class="iconSize"><i class="fa-brands fa-whatsapp"></i></a>
                            </li>
                        <?php } ?>
                        <?php if ($user->x_url) { ?>
                            <li><a href="<?= $user->x_url; ?>" target="_blank" class="iconSize"><i class="fa-brands fa-x-twitter"></i></a>
                            </li>
                        <?php } ?>
                        <?php if ($user->insta_url) { ?>
                            <li><a href="<?= $user->insta_url; ?>" target="_blank" class="iconSize"><i class="fa-brands fa-instagram"></i></a>
                            </li>
                        <?php } ?>

                    </ul>
                </div>
            </div>
        </div>
        <hr>
        <ul class="nav nav-pills mb-2 ms-2">
            <li class="nav-item"><a href="<?= Url::toRoute(['/profile/default/index', 'user_handle' => $user->user_handle]) ?>" class="nav-link <?= isset($profile) ? $profile : '' ?>">Profile</a></li>
            <li class="nav-item"><a href="<?= Url::toRoute(['/profile/share-safari/index', 'user_handle' => $user->user_handle]) ?>" class="nav-link <?= isset($share_safari) ? $share_safari : '' ?>">Shared Safari</a></li>
            <li class="nav-item"><a href="<?= Url::toRoute(['/profile/article/index', 'user_handle' => $user->user_handle]) ?>" class="nav-link <?= isset($article) ? $article : '' ?>">Article</a></li>
            <li class="nav-item"><a href="<?= Url::toRoute(['/profile/activity/index', 'user_handle' => $user->user_handle]) ?>" class=" nav-link <?= isset($activity) ? $activity : '' ?>">Activity</a></li>
            <li class="nav-item"><a href="<?= Url::toRoute(['/profile/contribution/index', 'user_handle' => $user->user_handle]) ?>" class="nav-link <?= isset($contribution) ? $contribution : '' ?>">Contribution</a></li>
            <li class="nav-item"><a href="<?= Url::toRoute(['/profile/photo/index', 'user_handle' => $user->user_handle]) ?>" class="nav-link <?= isset($photo) ? $photo : '' ?>">Photo</a></li>
            <?php if (Yii::$app->user->identity && Yii::$app->user->identity->id == $user->id) {
                if ($user->is_safari_operator == 1) { ?>
                    <li class="nav-item"><a href="<?= Url::toRoute(['/manage']) ?>" class="nav-link <?= isset($business) ? $business : '' ?>">Manage Business</a></li>
                    <?php } else if (in_array($user->account_type, [2, 3])) {
                    $business_request = SafariOperatorRequest::find()->where(['user_id' => $user->id])->one();
                    if ($business_request) { ?>
                        <li class="nav-item"><a href="<?= Url::toRoute(['/profile/business']) ?>" class="nav-link bg-info">Pending Business Request</a></li>
                    <?php } else { ?>
                        <li class="nav-item"><a href="<?= Url::toRoute(['/safaritour-registration']) ?>" class="nav-link bg-warning">Register Your Business</a></li>
                    <?php }
                    ?>
                <?php }
                ?>
            <?php } ?>
        </ul>
    </div>
</div>
<style>
    .mt-n5 {
        margin-top: -3rem !important;
    }

    .linear-gradient {
        background-image: linear-gradient(#09422dfc, #f9d600);
    }
</style>