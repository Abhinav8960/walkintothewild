<?php


use common\interfaces\Constants;
use common\models\cms\banner\Banner;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */

$this->title = 'Park Search Result';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
$park_constant = Constants::PARK_LIST;
$banner = Banner::find()->where(['status' => 1, 'page_id' => $park_constant])->limit(1)->one();
?>
<?php
Pjax::begin([
    'id' => 'grid-data',
    'enablePushState' => FALSE,
    'enableReplaceState' => FALSE,
    'timeout' => false,
]);

?>
<?php $form = ActiveForm::begin([
    'options' => [
        'data-pjax' => true,
        'id' => 'sideSearchform'
    ],
    'action' => Url::toRoute(['/park/default/rareanimal', 'slug' => $slug]),
    'method' => 'get',
]); ?>
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
                        <h1>Rare and Exotic Animal Safaris</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="articals_wrapper  margin_bottomfooter mt-lg-4 <?= $searchModel->master_rare_animal_id == '' ? 'margin-setposi' : '' ?>">
    <div class="container-fluid ">
        <!-- <div class="row justify-content-center">
            <div class="col-lg-7 mb-4">
                <div class="advertisment ">
                    <p class="text-center">ADVERTISMENT</p>
                    <div class="advertisment_box">

                    </div>
                </div>
            </div>
        </div> -->
        <div class="row mb-4 sticky_set e">
            <div class="col-lg-2 col-12 mb-lg-0 mb-3 ps-xl-5 pt-3">
                <div id="targetDiv">
                    <?= $this->render('_rareanimal_side_search', [
                        'model' => $searchModel,
                        'device' => $device,
                        'slug' => $slug,
                        'form' => $form
                    ]) ?>
                </div>
            </div>
            <div class="col-lg-10 col-12 paddingset_desktop ">
                <div class="topfilter d-lg-flex d-none justify-content-between align-items-center mb-2 flex-wrap w-100 ">
                    <div class="left_text">
                        <p class="mb-0">We found <strong><?= count($models) ?> parks</strong> for you</p>
                    </div>
                    <div class="right-select ">
                        <div class="input_check pb-0 mb-3">
                            <form id="custom_sort_by_form">
                                <?= $form->field($searchModel, 'custom_sort_by')->dropDownList(['is_most_demanding' => 'Most Demanding', 2 => 'Sort by: A to Z', 3 => 'Sort by: Z to A'], ['class' => 'form-select mb-2'])->label(false) ?>
                            </form>
                        </div>

                    </div>
                </div>
                <div class="top_mobilefilter mb-4 d-flex gap-2 d-lg-none justify-content-between align-items-center w-100">
                    <div class="left_text">
                        <p class="mb-0">We found <strong><?= count($models) ?> parks</strong> for you</p>
                    </div>
                    <div class="right-select mobile_serach mb-md-0 " id="mobileSearchDiv">
                        <div class="input_check pb-0">
                            <div class="filter_searchbox">
                                <span>Filter <i class="fa-solid fa-chevron-down"></i></span>
                            </div>
                        </div>

                    </div>
                </div>
                <?php if ($models) {
                    foreach ($models as $model) { ?>
                        <a href="<?= Url::toRoute(['/park/default/view', 'slug' => $model->slug]) ?>" class="parking_Box" data-pjax="0">
                            <div class="searchSafari_wraper mb-4">

                                <div class="row">
                                    <div class="col-xl-3 col-sm-4 col-md-3">
                                        <div class="Slider_safariimg3 h-100">
                                            <img src="<?= isset($model->logo) ? $model->logoimagepath : $this->params['baseurl'] . '/img/Bandhavgarhbig.jpg' ?>" alt="" class="w-100 h-100">
                                        </div>
                                    </div>
                                    <div class="col-md-9 col-sm-8 col-xl-9">
                                        <div class="safariSearch_wrap">
                                            <div class="safrititles tite_parklist pt-sm-0 pt-3">
                                                <h4 class=""><?= $model->title ?> | <span><?= isset($model->state) ? $model->state->state_name . ', ' : '' ?><?= isset($model->location) ? $model->location->title : '' ?></span></h4>
                                            </div>
                                            <div class="seelctes_text  pb-4 ">
                                                <p>
                                                    <?= $model->long_description ?>
                                                </p>
                                            </div>
                                            <div class="tour_logosliders ">
                                                <div class="taglines">
                                                    <!-- <p><a href="<?= \yii\helpers\Url::toRoute(['/park/default/view', 'slug' => $model->slug, '#' => 'safari_tour_operator_container']) ?>" style="color:inherit;">Top Safari Tour Operators</a></p> -->
                                                    <p>Top Safari Tour Operators</p>
                                                </div>
                                                <div class="touroprators">
                                                    <div class="opratios-slider owl-carousel imagzise owl-theme">
                                                        <?php if ($operator_list = $model->getSafarioperatorlist()->joinwith(['operator' => function ($operator_park_query) {
                                                            $operator_park_query->where(['safari_operator.status' => 1]);
                                                        }])->where(['safari_operator_park.status' => 1])->all()) {
                                                            foreach ($operator_list as $operator_park) { ?>
                                                                <div class="slidesImg">
                                                                    <img src="<?= isset($operator_park->operator->logo) ? $operator_park->operator->imagepath : $this->params['baseurl'] . '/img/Pugdundee.jpg' ?>" alt="" class="w-100">
                                                                </div>
                                                            <?php  }
                                                            ?>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </a>
                <?php }
                } ?>
            </div>
        </div>
    </div>
  
</section>
<?php ActiveForm::end(); ?>
<script>
    var mobileSearchDivAnimal = document.getElementById('mobileSearchDiv');
    var targetDivAnimal = document.getElementById('targetDiv');
    var formSelectAnimal = document.querySelector('.form-select');

    if (mobileSearchDivAnimal && targetDivAnimal) {
        mobileSearchDivAnimal.addEventListener('click', function(event) {
            event.stopPropagation(); // Prevent the default behavior
            targetDivAnimal.style.display = targetDivAnimal.style.display === 'none' ? 'block' : 'block';
        });

        if (formSelectAnimal) {
            formSelectAnimal.addEventListener('click', function(event) {
                event.stopPropagation();
            });
        }
    }
</script>
<?php Pjax::end(); ?>


