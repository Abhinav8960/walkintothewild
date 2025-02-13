<?php

use yii\helpers\Url;
use common\models\GeneralModel;
use common\interfaces\Constants;
use common\models\cms\banner\Banner;
use common\models\operator\SafariOperatorRating;
use common\models\sharesafari\ShareSafariIntrested;
use common\models\User;

/* @var $this yii\web\View */

$this->title = $operator->register_comapany_name . ' | Following';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$park_constant = Constants::OPERATOR_VIEW;
$banner = Banner::find()->where(['status' => 1, 'page_id' => $park_constant])->limit(1)->one();

?>


<section class="banner_section-inner packagebnner position-relative">
    <picture class="position-relative">
        <source srcset="<?= isset($banner->image) ? $banner->imagepath : $this->params['baseurl'] . '/img/banner-share.png' ?>" media="(max-width:576px)" type="image/webp">
        <img src="<?= isset($banner->image) ? $banner->imagepath : $this->params['baseurl'] . '/img/banner-share.png' ?>" class="d-block w-100 banner_search" alt="banner">
    </picture>
    <div class="banner_searchBox">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="headingBnner_inner">
                        <h1>Safari Tour Operator</h1>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
<section class="touroprator_section bg-white">
    <div class="container-fluid">
        <?= $this->render('_operator_overview', ['operator' => $operator]) ?>

        <?php if (Yii::$app->user->identity && Yii::$app->user->identity->id != $operator->user_id) { ?>
            <div class="row justify-content-center  mb-4">
                <div class="col-lg-12 col-xxl-7 col-xl-10" id="memberview">
                    <?= $this->render('_free_quote', [
                        'model' => $model,
                        'operator' => $operator,
                        'disabled' => false,
                    ]) ?>
                </div>
            </div>
        <?php } else {  ?>
            <div class="row justify-content-center mb-4">
                <div class="col-lg-12 col-xxl-7 col-xl-10 position-relative galssset " id="memberview">
                    <svg class="form-lock" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                        <path fill="#02690e" d="M144 144l0 48 160 0 0-48c0-44.2-35.8-80-80-80s-80 35.8-80 80zM80 192l0-48C80 64.5 144.5 0 224 0s144 64.5 144 144l0 48 16 0c35.3 0 64 28.7 64 64l0 192c0 35.3-28.7 64-64 64L64 512c-35.3 0-64-28.7-64-64L0 256c0-35.3 28.7-64 64-64l16 0z" />
                    </svg>
                    <?= $this->render('_free_quote', [
                        'model' => $model,
                        'operator' => $operator,
                        'disabled' => true,
                    ]) ?>
                </div>
            </div>
        <?php }   ?>
    </div>
    <div class="container-fluid">
        <?= $this->render('_view_navbar', ['active' => 'follower', 'operator' => $operator]) ?>
    </div>

</section>
<section class="touroprator_section  margin_bottomfooter">
    <div class="container-fluid" id="viewcontent">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-xxl-9 col-lg-12">
                <div class="row pt-5 pb-4">
                    <div class="col-lg-12 col-md-12 col-xxl-12 col-xl-12">
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <div class="card card_bodyPadding">
                                    <div class="card-body">
                                        <div class="tab-content_tour active">
                                            <div class="col-md-12">
                                                <h6 class="fs-5 fw-bold pb-3">Following</h5>
                                            </div>
                                            <div class="row">
                                                <?php if ($user = $operator->user) {
                                                    if ($operator_following = $user->getUserfollowings()->joinWith('user')->where(['user_follower.status' => 1, 'user.status' => User::STATUS_ACTIVE])->all()) {
                                                        foreach ($operator_following as $operatorfollowing) { ?>
                                                            <div class="col-sm-12 col-md-3">
                                                                <section class="mx-auto pb-3">
                                                                    <?= $this->render('@frontend/modules/profile/views/default/_profile_card', ['user' => $operatorfollowing->follower]);  ?>
                                                                </section>
                                                            </div>
                                                <?php  }
                                                    }
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
            </div>
        </div>
    </div>
</section>

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