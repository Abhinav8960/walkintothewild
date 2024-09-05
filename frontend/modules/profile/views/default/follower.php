<?php

use common\interfaces\StatusInterface;
use common\models\operator\SafariOperator;
use common\models\User;
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

                            <div class="card position-relative">
                                <div class="card-body">
                                    <div class="row">
                                        <?php if ($userfollowers = $user->getUserfollowers()->joinWith('user')->where(['user.status' => User::STATUS_ACTIVE, 'user_follower.status' => 1])->all()) {
                                            foreach ($userfollowers as $userfollower) { ?>
                                                <div class="col-md-4 col-lg-3 col-sm-6 mb-3">
                                                    <section class="mx-auto" style="max-width: 23rem;">
                                                        <?= $this->render('@frontend/modules/profile/views/default/_profile_card', ['user' => $userfollower->user]);  ?>
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