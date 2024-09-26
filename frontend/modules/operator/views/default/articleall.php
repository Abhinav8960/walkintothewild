<?php

use common\interfaces\Constants;
use common\models\cms\banner\Banner;

use common\models\GeneralModel;
use common\models\operator\SafariOperatorRating;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = 'Safari Operator  | ' . $operator->register_comapany_name . ' | Reviews';
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
                        <!-- <p class="text-center text-white">Create Your Custom Safari Experience or Join Others on
                                Their Adventures</p> -->
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
        <?= $this->render('_view_navbar', ['active' => 'article', 'operator' => $operator]) ?>
    </div>

</section>
<section class="touroprator_section  margin_bottomfooter">
    <div class="container-fluid" id="viewcontent">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-xxl-9 col-lg-12">
                <div class="row pt-5">
                    <div class="col-md-12">
                        <div class="tab-content_tour mb-4 active">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card card_bodyPadding">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between  mb-4">
                                                <h6 class="fs-6 fw-bold mb-0" style="padding-bottom: 0 !important;"><?= $operator->businessname ?> Published <span class="numberFont"><?= $dataProvider->getTotalCount() ?></span> Article</h6>
                                            </div>

                                            <div class="row">
                                                <?php if ($dataProvider->models) {
                                                    foreach ($dataProvider->models as $article) { ?>
                                                        <div class="col-md-6 mb-5">
                                                            <div class="artical_cards h-100">
                                                                <div class="image-box">
                                                                    <figure class="image"><a href="/article/<?= $article->slug ?>" data-pjax="0"><img src="<?= isset($article->banner_image) ? $article->bannerimagepath : $this->params['baseurl'] . '/img/Article1.jpg' ?>" alt=""></a>
                                                                    </figure>
                                                                </div>
                                                                <div class="lower-content">
                                                                    <ul class="artical-info ">
                                                                        <li><i class="fa-solid fa-user"></i><a href="<?= Url::toRoute(['/article/default/author', 'slug' => $article->articleAuthor ? $article->articleAuthor->slug : '']) ?>" data-pjax="0"><?= isset($article->articleAuthor) ? $article->articleAuthor->author_name : '' ?></a></li>

                                                                    </ul>
                                                                    <h3><a href="<?= Url::toRoute(['/article/default/view', 'slug' => $article->slug]) ?>" data-pjax="0"><?= $article->title ?> </a></h3>

                                                                    <div class="artical-info justify-content-center">
                                                                        <a href="<?= Url::toRoute(['/article/default/view', 'slug' => $article->slug]) ?>" style="color: #9C9C9C;" data-pjax="0"><img src="<?= $this->params['baseurl'] ?>/img/comments.png" alt=""> <?= $article->getArticlecomments()->where(['status' => 1])->count() ?> Comments</a>

                                                                        <span style="color: #9C9C9C;"><i class="fa-solid fa-calendar-days me-1" style="color:#f9d600;"></i><?= date('M d, Y', strtotime($article->article_date)) ?></span>
                                                                    </div>


                                                                </div>
                                                                <div class="link"><a href="<?= Url::toRoute(['/article/default/view', 'slug' => $article->slug]) ?>" data-pjax="0"><i class="fa-solid fa-arrow-right"></i></a></div>
                                                            </div>
                                                        </div>
                                                <?php }
                                                } ?>
                                            </div>
                                            <?php
                                            echo \yii\widgets\LinkPager::widget([
                                                'pagination' => $dataProvider->pagination,
                                            ]);
                                            ?>
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