<?php

use common\interfaces\Constants;
use common\models\cms\banner\Banner;
use common\models\GeneralModel;
use frontend\models\ArticleSearch;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;


/* @var $this yii\web\View */

$this->title = 'Article  ' . $model->title;
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$park_constant = Constants::ARTICLE_DETAIL;
$banner = Banner::find()->where(['status' => 1, 'page_id' => $park_constant])->limit(1)->one();
$recentposts = ArticleSearch::recentpost();

?>

<section class="banner_section-inner position-relative">
    <picture class="position-relative">
        <source srcset="<?= isset($banner->image) ? $banner->imagepath : $this->params['baseurl'] . '/img/articlebanner.png' ?>" media="(max-width:576px)" type="image/webp">
        <img src="<?= isset($banner->image) ? $banner->imagepath : $this->params['baseurl'] . '/img/articlebanner.png' ?>" class="d-block w-100" alt="banner">
    </picture>
    <div class="banner_searchBox">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="headingBnner_inner">
                        <h1><?= $model->title ?></h1>
                        <p></p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<section class="articals_wrapper py-3">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-7 mb-5 py-3">
                <div class="advertisment ">
                    <p class="text-center">ADVERTISMENT</p>
                    <div class="advertisment_box">

                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-lg-9">
                <div class="aritcla-details">
                    <h1 class="articald-title pb-3"><?= $model->title ?></h1>
                    <div class="aritcal_bigimg pb-4">
                        <img src="<?= isset($model->banner_image) ? $model->bannerimagepath : $this->params['baseurl'] . '/img/articalbig.png' ?>" alt="" class="w-100">
                    </div>

                    <p><?= $model->description ?> </p>


                </div>
                <div class="tags-wrapper  my-5 d-flex justify-content-between flex-wrap align-items-center">
                    <div class="d-flex align-items-center">
                        <h3 class="me-4 mb-0">Tags</h3>
                        <?= $this->render('_tag_search') ?>
                    </div>
                    <div class="author_wrapper">
                        <ul class="artical-info ">
                            <li><img src="<?= $this->params['baseurl'] ?>/img/author.png" alt=""><a href=""><?= isset($model->articleAuthor) ? $model->articleAuthor->author_name : '' ?></a></li>
                            <li><img src="<?= $this->params['baseurl'] ?>/img/comments.png" alt=""><a href=""><?= count($model->articlecomments) ?> Comments</a></li>
                        </ul>
                    </div>
                </div>
                <div class="comment-wrapper">
                    <div class="commentCount mb-4">
                        <h6>4 Comments</h6>
                    </div>
                    <div class="comments-persons">
                        <div class="postcomment d-flex gap-3">
                            <div class="avatar">
                                <img src="<?= $this->params['baseurl'] ?>/img/dpmain.png" alt="">
                            </div>
                            <div class="text_com">
                                <h6 class="nameavatr">Gufran Ahmad</h6>
                                <p>Oh, that sounds amazing! I've always wanted to experience the thrill of seeing
                                    wild animals up close.</p>
                            </div>
                        </div>
                    </div>
                    <div class="comments-persons">
                        <div class="postcomment d-flex gap-3">
                            <div class="avatar">
                                <img src="<?= $this->params['baseurl'] ?>/img/dpmain.png" alt="">
                            </div>
                            <div class="text_com">
                                <h6 class="nameavatr">Rahul Kumar</h6>
                                <p>Count me in! Safari trips are incredible opportunities to connect with nature and
                                    witness some of the most stunning landscapes on Earth.</p>
                            </div>
                        </div>
                    </div>
                    <div class="comments-persons">
                        <div class="postcomment d-flex gap-3">
                            <div class="avatar">
                                <img src="<?= $this->params['baseurl'] ?>/img/dpmain.png" alt="">
                            </div>
                            <div class="text_com">
                                <h6 class="nameavatr">Rahul Kumar</h6>
                                <p>Count me in! Safari trips are incredible opportunities to connect with nature and
                                    witness some of the most stunning landscapes on Earth.</p>
                            </div>
                        </div>
                    </div>
                    <div class="comments-persons">
                        <div class="postcomment d-flex gap-3">
                            <div class="avatar">
                                <img src="<?= $this->params['baseurl'] ?>/img/dpmain.png" alt="">
                            </div>
                            <div class="text_com">
                                <h6 class="nameavatr">Rahul Kumar</h6>
                                <p>Absolutely! I've heard the sunrise safaris are especially breathtaking. Imagine
                                    the golden hues of the savannah as the animals come to life.</p>
                            </div>
                        </div>
                    </div>
                    <div class="comments-persons">
                        <div class="postcomment d-flex gap-3">
                            <div class="avatar">
                                <img src="<?= $this->params['baseurl'] ?>/img/dpmain.png" alt="">
                            </div>
                            <div class="text-area">
                                <textarea name="" class="form-control w-100" placeholder="Write a comment..."></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-end comments-persons">
                        <div class="col-6 ">
                            <div class="comment_button float-end ">
                                <button class="post-comment">Post Comment</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 mt-lg-0 mt-3">
                <?= $this->render('recent_posts', [
                    'recentposts' => $recentposts,
                ]) ?>
                <div class="topics_box">
                    <div class="titlerescent pb-3">
                        <h3>Topics</h3>
                    </div>
                    <?= $this->render('_topic_search') ?>
                </div>
                <div class="advertisment pt-5">
                    <p class="text-center">ADVERTISMENT</p>
                    <div class="advertisment_box">

                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>
</section>
<section class="safariduring_sesons">
    <?= $this->render('park_carousel', [
        'featured_parks' => $featured_parks,
    ]) ?>
</section>

<section class="bg_sky">
    <div class="container-lg">
        <div class="row">
            <div class="col-lg-6 mb-5 mb-lg-4">
                <div class="registration_img position-relative">
                    <img src="<?= $this->params['baseurl'] ?>/img/Registration-banner1.png" alt="" class="w-100">
                    <div class="registratin_text text-center">
                        <h6>Register your business as a <br>Safari Tour Operator</h6>

                        <div class="btn_r">
                            <a href="/safaritour-registration" class="btn_registrtion">Register Now</a>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-5 mb-lg-4">
                <div class="registration_img  position-relative">
                    <img src="<?= $this->params['baseurl'] ?>/img/Registration-banner2.png" alt="" class="w-100">
                    <div class="registratin_text text-center">
                        <h6>Register your business as a <br>Birding Tour Operator</h6>

                        <div class="btn_r">
                            <a href="/birdingtour-registration" class="btn_registrtion">Register Now</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</section>