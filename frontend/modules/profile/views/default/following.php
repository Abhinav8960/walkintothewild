<?php

use common\interfaces\NewStatusInterface;
use common\models\operator\SafariOperatorFollow;
use common\models\User;
use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$this->title = $user->name . ' | Following';
$this->params['title'] = $this->title;
?>
<section class="profile-wrapper">
    <div class="container-lg mb-5">
        <?= $this->render('@frontend/modules/profile/views/default/tablist', ['profile' => 'active', 'user' => $user]) ?>
    </div>
</section>
<?php if (Yii::$app->user->identity) { ?>
    <section class="margin_bottomfooter">
        <div class="container-lg">
            <div class="row justify-content-center mb-5">
                <div class="col-xxl-11 mb-5 ">
                    <div class="row  mb-5 itenary_tabs">
                        <div class="col-md-12">
                            <h6 class="fs-5 fw-bold pb-3">Following</h6>
                        </div>
                        <div class="col-12">

                            <div class="card  safartabs">
                                <div class="card-body">
                                    <ul class="nav  nav-tabs border-bottom" id="myTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Profile Following</button>
                                        </li>

                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="profile-tab " data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Operator Following</button>
                                        </li>

                                    </ul>
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active mt-3" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab">

                                            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-3 row-cols-xl-4 row-cols-xxl-5">
                                                <?php if ($userfollowers = $user->getUserfollowings()->joinWith('user')->where(['user.status' => User::STATUS_ACTIVE, 'user_follower.status' => 1])->all()) {
                                                    foreach ($userfollowers as $userfollower) { ?>
                                                        <div class="col mb-3">

                                                            <?= $this->render('@frontend/modules/profile/views/default/_profile_card', ['user' => $userfollower->follower]);  ?>

                                                        </div>
                                                <?php  }
                                                } else {
                                                    echo '<div class="col-md-12">
                    There is no following!
                </div>';
                                                } ?>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab">
                                            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-3 row-cols-xl-4 row-cols-xxl-5">


                                                <?php
                                                $operatorfollowings = SafariOperatorFollow::find()->where(['user_id' => $user->id, 'status' => NewStatusInterface::STATUS_ACTIVE])->all();
                                                if ($operatorfollowings) {
                                                    foreach ($operatorfollowings as $operatorfollowing) {
                                                        if ($operator = $operatorfollowing->operator) {

                                                ?>
                                                            <div class="card_profile card position-relative mt-2">
                                                                <div class="dots-blockbox">
                                                                    <i class="fa-solid fa-ellipsis"></i>
                                                                    <div class="box_dropdown">
                                                                        <a href="<?= Url::toRoute(['/operator/default/view', 'slug' => $operator->slug]) ?>" class="d-block pb-1">View Page</a>
                                                                    </div>
                                                                </div>
                                                                <div class="profileDetails  text-center">
                                                                    <a href="<?= Url::toRoute(['/operator/default/view', 'slug' => $operator->slug]) ?>">
                                                                        <div class=" mx-auto white" style="width: 70px; height:70px">
                                                                            <img src="<?= isset($operator->logo) ? $operator->imagepath : '/img/witw.png' ?>" class="rounded-circle img-fluid" alt="profile-image">
                                                                        </div>
                                                                        <div class="card-body text-center  pt-2">
                                                                            <h6 class="fs-7 fw-bold usename"><?= $operator->businessname ?></h6>
                                                                        </div>
                                                                    </a>
                                                                    <div class="followunfollowbtn border-top ">
                                                                        <?php
                                                                        if ($login_user = Yii::$app->user->identity) {
                                                                            if ($login_user->id <> $user->id) { ?>
                                                                                <div class="row">
                                                                                    <div class="col-6">
                                                                                        <div class="folollowBtns ">
                                                                                            <?php
                                                                                            $operator_follower = SafariOperatorFollow::find()->where(['user_id' => $login_user->id, 'status' => 1])->limit(1)->one();
                                                                                            if ($operator_follower) { ?>
                                                                                                <a href="<?= Url::toRoute(['/operator/default/unfollow', 'slug' => $operator->slug]) ?>" data-method="POST">Unfollow</a>
                                                                                            <?php  } else { ?>
                                                                                                <a href="<?= Url::toRoute(['/operator/default/follow', 'slug' => $operator->slug]) ?>" data-method="POST">Follow</a>
                                                                                            <?php } ?>
                                                                                        </div>
                                                                                    </div>
                                                                                    <!-- <div class="col-6">
                                            <div class="massegses">
                                                <a href="<?= Url::toRoute(['/chat/default/message', 'user_handle' => $user->user_handle]) ?>">Message</a>
                                            </div>
                                        </div> -->
                                                                                </div>
                                                                            <?php } else { ?>
                                                                                <div class="row">
                                                                                    <div class="col-12 ">
                                                                                        <div class="massegses">
                                                                                            <a href="<?= Url::toRoute(['/operator/default/unfollow', 'slug' => $operator->slug]) ?>" data-method="POST">Unfollow</a>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            <?php }
                                                                        } else { ?>
                                                                            <div class="row">
                                                                                <div class="col-6 divider">
                                                                                    <div class="folollowBtns">
                                                                                        <a href="/site/login?authclient=google&referrer=<?= Url::toRoute(['/operator/default/follow', 'slug' => $operator->slug]) ?>">Follow</a>
                                                                                    </div>
                                                                                </div>
                                                                                <!-- <div class="col-6">
                                        <div class="massegses">
                                            <a href="/site/login?authclient=google&referrer=<?= Url::toRoute(['/chat/default/message', 'user_handle' => $user->user_handle]) ?>">Message</a>
                                        </div>
                                    </div> -->
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                <?php }
                                                    }
                                                } ?>


                                            </div>
                                        </div>
                                    </div>



                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

        </div>
    </section>
<?php } else { ?>

    <div class="container-lg">
        <div class="row justify-content-center">
            <div class="col-xxl-11 margin_bottomfooter">
                <div class="card position-relative" style="min-height: 350px;">
                    <div class="card-body">
                        <div class="withoutlogedin">
                            <h6 class="fs-6 fw-bold">Following</h6>
                        </div>

                        <div class="logininfo text-center">
                            <h6>Please log in to view the Followers</h6>
                            <div class="viewAllreview">
                                <a href="/site/login?authclient=google&referrer=<?= Url::toRoute(['/profile/default/following', 'user_handle' => $user->user_handle]) ?>">Login</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dots = document.querySelectorAll('.dots-blockbox');

        dots.forEach(dot => {
            const icon = dot.querySelector('.fa-ellipsis');
            const box = dot.querySelector('.box_dropdown');

            icon.addEventListener('click', function(event) {
                event.stopPropagation();
                const currentlyOpen = document.querySelector('.box_dropdown.show');
                if (currentlyOpen && currentlyOpen !== box) {
                    currentlyOpen.classList.remove('show');
                    currentlyOpen.style.display = 'none';
                }
                box.style.display = box.style.display === 'none' || !box.style.display ? 'block' : 'none';
                box.classList.toggle('show');
            });
        });

        document.addEventListener('click', function() {
            const openBox = document.querySelector('.box_dropdown.show');
            if (openBox) {
                openBox.style.display = 'none';
                openBox.classList.remove('show');
            }
        });
    });
</script>