<?php

use common\interfaces\Constants;
use common\models\cms\banner\Banner;
use common\models\GeneralModel;
use frontend\models\ArticleSearch;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = 'Article  ' . $article->title;
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
                        <h1><?= $article->title ?></h1>
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
        <div class="row mb-4 justify-content-center">
            <div class="col-lg-8 col-xl-8 col-xxl-9 pe-xl-5">
                <div class="aritcla-details">
                    <!-- <h1 class="articald-title pb-3"><?= $article->title ?></h1> -->
                    <div class="aritcal_bigimg pb-4">
                        <img src="<?= isset($article->banner_image) ? $article->bannerimagepath : $this->params['baseurl'] . '/img/articalbig.png' ?>" alt="" class="w-100">
                    </div>

                    <p><?= $article->description ?> </p>


                </div>

                <div class="tags-wrapper  my-5 d-flex justify-content-between flex-wrap align-items-center">
                    <div class="author_wrapper">
                        <ul class="artical-info ">
                            <?php if ($topics = $article->articletopics) {
                                foreach ($topics as $topic) { ?>
                                    <li><svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="20" height="20" x="0" y="0" viewBox="0 0 32 32" style="enable-background:new 0 0 512 512" xml:space="preserve" class="hovered-paths"><g><path d="M18.885 7.215h-8.6a1.48 1.48 0 0 1-1.48-1.48V3.48c0-.817.663-1.48 1.48-1.48h8.6c.817 0 1.48.663 1.48 1.48v2.255a1.48 1.48 0 0 1-1.48 1.48zM28.83 17.99c-.92-.92-2.42-.92-3.34 0l-1.092 1.098 3.342 3.341 1.09-1.09c.93-.929.93-2.419 0-3.349zM23.34 20.15l-5.83 5.82c-.12.13-.2.29-.23.46l-.44 2.59c-.1.57.4 1.06.97.97l2.59-.44c.17-.03.33-.11.45-.23l5.83-5.83z" fill="#f7bf39" opacity="1" data-original="#000000" class="hovered-path"></path><path d="M23.11 4.61h-1.245v1.125a2.984 2.984 0 0 1-2.98 2.98h-8.6a2.983 2.983 0 0 1-2.98-2.98V4.61H6.04c-1.97 0-3.57 1.6-3.57 3.57v18.25c0 1.97 1.6 3.57 3.57 3.57h9.457a2.309 2.309 0 0 1-.135-1.238l.439-2.583c.078-.458.288-.881.604-1.226l6.365-6.356 1.655-1.664a3.816 3.816 0 0 1 2.253-1.086V8.19a3.559 3.559 0 0 0-3.568-3.58zM13.028 19.443H8.689a.9.9 0 0 1 0-1.8h4.339a.9.9 0 0 1 0 1.8zm5.312-5.108H8.69a.9.9 0 0 1 0-1.8h9.65a.9.9 0 0 1 0 1.8z" fill="#f7bf39" opacity="1" data-original="#000000" class="hovered-path"></path></g></svg><a href="<?= Url::toRoute(['/article/default/topic', 'slug' => $topic->articlename->slug]) ?>"><?= isset($topic->articlename->title) ? $topic->articlename->title : ''; ?></a></li>
                            <?php }
                            } ?>


                        </ul>
                    </div>
                </div>
                <div class="tags-wrapper  my-5 d-flex justify-content-between flex-wrap align-items-center">
                    <div class="d-flex align-items-center">
                        <h3 class="me-4 mb-0 tags-title">Tags</h3>
                        <?= $this->render('_tag_search') ?>
                    </div>
                    <div class="author_wrapper">
                        <ul class="artical-info ">
                            <li><img src="<?= $this->params['baseurl'] ?>/img/author.png" alt=""><a href="<?= Url::toRoute(['/article/default/author', 'slug' => $article->articleAuthor ? $article->articleAuthor->slug : '']) ?>"><?= isset($article->articleAuthor) ? $article->articleAuthor->author_name : '' ?></a></li>
                            <li><img src="<?= $this->params['baseurl'] ?>/img/comments.png" alt=""><a href=""><?= $article->getArticlecomments()->where(['status' => 1])->count() ?> Comments</a></li>
                            <li><i class="fa-solid fa-calendar-days"></i><a href=""><?= date('M d, Y', strtotime($article->article_date)) ?></a></li>

                        </ul>
                    </div>
                </div>
                <div class="comment-wrapper" id="comment-wrapper-section">
                    <?= $this->render('_comment', [
                        'model' => $model,
                        'article' => $article,
                    ]) ?>
                </div>
            </div>
            <div class="col-lg-4 col-xl-3 col-xxl-2  mt-lg-0 mt-3">
                <?= $this->render('_recent_posts', [
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
    <?= \frontend\widgets\FeatureParkWidget::widget() ?>
</section>

<section class="bg_sky">
    <div class="container-lg">
        <div class="row">
            <div class="col-lg-6 mb-5 mb-lg-4">
                <div class="registration_img position-relative">
                    <img src="<?= $this->params['baseurl'] ?>/img/Registration-banner1.png" alt="" class="w-100" loading="lazy">
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
                    <img src="<?= $this->params['baseurl'] ?>/img/Registration-banner2.png" alt="" class="w-100" loading="lazy">
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