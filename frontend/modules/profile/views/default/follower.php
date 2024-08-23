<?php

use common\interfaces\StatusInterface;
use common\models\operator\SafariOperator;
use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$this->title = $user->name . ' | Followers';
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
                <div class="col-xxl-11 mb-5">
                    <div class="row mb-5 itenary_tabs">
                        <div class="col-md-12">
                            <h6 class="fs-5 fw-bold pb-3">Followers</h5>
                        </div>
                        <div class="col-12">
                            <?php if ($user->is_safari_operator == 1) { ?>
                                <div class="card  safartabs position-relative">
                                    <div class="card-body">
                                        <ul class="nav  nav-tabs border-bottom" id="pills-tab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Profile Follower</button>
                                            </li>

                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Page Follower</button>
                                            </li>

                                        </ul>
                                        <div class="tab-content" id="pills-tabContent">
                                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">

                                                <div class="row">
                                                    <?php if ($userfollowers = $user->getUserfollowers()->where(['status' => 1])->all()) {
                                                        foreach ($userfollowers as $userfollower) { ?>
                                                            <div class="col-md-4 col-lg-3 col-sm-6 mb-3">
                                                                <section class="mx-auto" style="max-width: 23rem;">
                                                                    <?= $this->render('@frontend/modules/profile/views/default/_profile_card', ['user' => $userfollower->user, 'profile_user' => $user]);  ?>
                                                                </section>
                                                            </div>
                                                    <?php  }
                                                    } else {
                                                        echo '<div class="col-md-12 pt-3">
                    There is no follower!
                </div>';
                                                    } ?>
                                                </div>

                                            </div>

                                            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">

                                                <div class="row">
                                                    <?php if ($operator = SafariOperator::find()->where(['user_id' => Yii::$app->user->identity ? Yii::$app->user->identity->id : null, 'status' => StatusInterface::STATUS_ACTIVE])->limit(1)->one()) {
                                                        if ($followers = $operator->getFollowerlist()->where(['status' => 1])->all()) {
                                                            foreach ($followers as $follower) { ?>
                                                                <div class="col-md-3 col-lg-3 col-sm-6 mb-3">
                                                                    <section class="mx-auto" style="max-width: 23rem;">
                                                                        <?= $this->render('@frontend/modules/profile/views/default/_profile_card', ['user' => $follower->user, 'profile_user' => $user]);  ?>
                                                                    </section>
                                                                </div>
                                                    <?php }
                                                        }
                                                    } else {
                                                        echo '<div class="col-md-12 pt-3">No Follower Found!</div>';
                                                    } ?>
                                                </div>


                                            </div>
                                        </div>
                                    </div>


                                </div>
                            <?php } else {  ?>
                                <div class="card position-relative">
                                    <div class="card-body">
                                        <div class="row">
                                            <?php if ($userfollowers = $user->getUserfollowers()->where(['status' => 1])->all()) {
                                                foreach ($userfollowers as $userfollower) { ?>
                                                    <div class="col-md-4 col-lg-3 col-sm-6 mb-3">
                                                        <section class="mx-auto" style="max-width: 23rem;">
                                                            <?= $this->render('@frontend/modules/profile/views/default/_profile_card', ['user' => $userfollower->user, 'profile_user' => $user]);  ?>
                                                        </section>
                                                    </div>
                                            <?php  }
                                            } else {
                                                echo '<div class="col-md-12 pt-3">
                    There is no follower!
                </div>';
                                            } ?>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
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
                            <h6 class="fs-6 fw-bold">Followers</h6>
                        </div>

                        <div class="logininfo text-center">
                            <h6>Please log in to view the Followers</h6>
                            <div class="viewAllreview">
                                <a href="/site/login?authclient=google&referrer=<?= Url::toRoute(['/profile/default/follower', 'user_handle' => $user->user_handle]) ?>">Login</a>
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