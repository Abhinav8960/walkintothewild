<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use common\models\GeneralModel;
use common\interfaces\Constants;
use common\models\cms\banner\Banner;
use common\models\park\SafariParkRating;
use common\models\suggestions\SafariSuggestions;

/* @var $this yii\web\View */

$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$park_constant = Constants::PARK_VIEW;
$banner = Banner::find()->where(['status' => 1, 'page_id' => $park_constant])->limit(1)->one();

if ($model->meta_description != '') {
    $this->params['meta_description'] = $model->meta_description;
}

if ($model->meta_keywords != '') {
    $this->params['meta_keywords'] = $model->meta_keywords;
}
if ($model->meta_title != '') {
    $this->title = $model->meta_title;
} else {
    $this->title = 'Safari ' . $model->title;
}
?>

<section class="banner_section-inner ee position-relative">
    <picture class="position-relative">
        <source srcset="<?= isset($banner->image) ? $banner->imagepath : $this->params['baseurl'] . '/img/NewBanner_big.png' ?>" media="(max-width:576px)" type="image/webp">
        <img src="<?= isset($banner->image) ? $banner->imagepath : $this->params['baseurl'] . '/img/NewBanner_big.png' ?>" class="d-block w-100 " alt="banner">
    </picture>
    <div class="banner_searchBox">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="headingBnner_inner">
                        <h1><?= $model->title ?></h1>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<section class="articals_wrapper  pb-5 mb-5">
    <div class="container-fluid" id="viewcontent">
        <div class="row justify-content-center">
            <div class="col-xl-11 col-lg-12">
                <div class="row pt-5">
                    <div class="col-lg-9 col-md-8 col-xxl-10 col-xl-9 ">
                        <div class="tab-content_tour mb-4 active">
                            <div class="row">
                                <div class="col-12 mb-4 mt-5">
                                    <div class="comments_safari operator_comment">
                                        <div class="commentsOther  position-relative">
                                            <div class=" d-flex justify-content-between flex-wrap">
                                                <?php



                                                if ($suggestions) { ?>
                                                    <div class="userRatingTitle">
                                                        <h6 class="nameRating">Average User Suggestions</h6>
                                                        <div class="providerNamerating d-flex gap-4 align-items-center pb-3">
                                                            <?php $count = SafariSuggestions::find()->where(['status' => 1, 'park_id' => $model->id])->count(); {
                                                                if ($count) { ?>
                                                                    <div class="googlerating">
                                                                        <p class="mb-0"><?= $count . " " ?>Suggestions</p>
                                                                    </div>
                                                            <?php }
                                                            } ?>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                                <div class="whiteReview mt-2">
                                                    <?php if (Yii::$app->user->id) {  ?>

                                                        <div class="title_filter mb-3">
                                                            <button value="<?= Url::toRoute(['/park/default/suggestion', 'park_id' => $model->id]) ?>" class="btn_newsafari writeSuggestionBtn" data-bs-toggle="modal" data-bs-target="#exampleModal3">Suggest Correction </button>
                                                        </div>
                                                    <?php } else {
                                                        echo 'Please <a href="/site/auth?authclient=google" class="sign_intext">Sign in</a> for giving your contribution';
                                                    } ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="review-list">
                                            <?php
                                            if ($suggestions) {
                                                foreach ($suggestions as $suggestion) {
                                            ?>
                                                    <div class="comments-persons">
                                                        <div class="postcomment">
                                                            <div class="itenary-title">
                                                                <h6 class="nameavatr"><?= isset($suggestion->name) ? $suggestion->name : '' ?></h6>
                                                            </div>
                                                            <div class="itenary_text">
                                                                <p><?= isset($suggestion->master_suggestion_id) ? GeneralModel::suggestioncategory()[$suggestion->master_suggestion_id] : '' ?><br><?= isset($suggestion->details) ? $suggestion->details : '' ?></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                            <?php }
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

<!-- Modal -->
<div class="modal fade" id="suggestion-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Suggest Correction</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id='modalContent'></div>
            </div>
        </div>
    </div>
</div>

<?php
$script = <<< JS
function writesuggestionfunction() {
	$('.writeSuggestionBtn').on('click', function () {
        $('#suggestion-modal').modal('show')
		.find('#modalContent')
		.load($(this).attr('value'));
	});
}
writesuggestionfunction();


             
JS;
$this->registerJs($script);
?>