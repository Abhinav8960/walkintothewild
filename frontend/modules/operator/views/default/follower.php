<?php

use yii\helpers\Url;
use common\models\GeneralModel;
use common\interfaces\Constants;
use common\models\cms\banner\Banner;
use common\models\operator\SafariOperatorRating;
use common\models\sharesafari\ShareSafariIntrested;


/* @var $this yii\web\View */

$this->title = 'Safari Operator  | ' . $operator->register_comapany_name . ' | Followes';
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

        <?php if (Yii::$app->user->identity) { ?>
            <div class="row justify-content-center  mb-4">
                <?= $this->render('_free_quote', [
                    'model' => $model,
                    'operator' => $operator,
                ]) ?>
            </div>
        <?php } ?>
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
                            <div class=" col-xxl-8 col-lg-8 mb-4">
                                <div class="card card_bodyPadding">
                                    <div class="card-body">
                                        <div class="tab-content_tour active">
                                            <div class="col-md-12">
                                                <h6 class="fs-5 fw-bold pb-3">Followers</h5>
                                            </div>
                                            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-2 row-cols-xl-3 row-cols-xxl-3">
                                                <?php if ($operatorfollowers = $operator->getFollowerlist()->where(['status' => 1])->all()) {
                                                    foreach ($operatorfollowers as $operatorfollower) { ?>
                                                        <div class="col">
                                                            <section class="mx-auto" >
                                                                <?= $this->render('@frontend/modules/profile/views/default/_profile_card', ['user' => $operatorfollower->user, 'profile_user' => $user]);  ?>
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
                            <div class="col-xxl-4 col-lg-4">
                                <?= $this->render('_operator_rating_sidebar', ['operator' => $operator]) ?>
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