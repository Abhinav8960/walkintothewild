<?php


/* @var $this yii\web\View */

use yii\helpers\Url;
use common\interfaces\Constants;
use frontend\models\ArticleSearch;
use common\models\cms\banner\Banner;

$this->title = 'Article';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
$park_constant = Constants::ARTICLE_LISTING;
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
                        <h1>Articles & Tips</h1>
                        
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<section class="articals_wrapper py-3">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-7 mb-4">
                <div class="advertisment ">
                    <p class="text-center">ADVERTISMENT</p>
                    <div class="advertisment_box">

                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4  justify-content-center">
            <div class="col-xl-12 col-lg-12">
               <div class="row justify-content-center gx-lg-5">
               <div class="col-lg-8 col-xl-8 col-xxl-9">
                <div class="topics_tags">
                <h4 class="fs-4"><?= isset($slug) ? strtoupper($slug) : '' ?></h4>
                </div>
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-2 row-cols-xl-2 row-cols-xxl-3  gx-xxl-5 gx-lg-4 ">
                    <?php if ($models) {
                        foreach ($models as $model) { ?>
                            <div class="col mb-5">
                                <div class="artical_cards h-100">
                                    <div class="image-box">
                                        <figure class="image"><a href="/article/<?= $model->slug ?>"><img src="<?= isset($model->feature_image) ? $model->featureimagepath : $this->params['baseurl'] . '/img/Article1.jpg' ?>" alt=""></a>
                                        </figure>
                                    </div>
                                    <div class="lower-content">
                                        <ul class="artical-info ">
                                            <li><img src="<?= $this->params['baseurl'] ?>/img/author.png" alt=""><a href="<?= Url::toRoute(['/article/default/author', 'slug' => $model->articleAuthor ? $model->articleAuthor->slug : '']) ?>"><?= isset($model->articleAuthor) ? $model->articleAuthor->author_name : '' ?></a></li>
                                            <li><img src="<?= $this->params['baseurl'] ?>/img/comments.png" alt=""><a href="<?= Url::toRoute(['/article/default/view', 'slug' => $model->slug, '#' => 'comment-wrapper-section']) ?>"><?= $model->getArticlecomments()->where(['status' => 1])->count() ?> Comments</a></li>
                                            
                                        </ul>
                                        <h3><a href="<?= Url::toRoute(['/article/default/view', 'slug' => $model->slug]) ?>"><?= $model->title ?> </a></h3>

                                        <!-- <ul class="artical-info ">
                                            <?php if ($topics = $model->getArticletopics()->where(['status' => 1])->orderby('RAND()')->limit(3)->all()) {
                                                foreach ($topics as $topic) { ?>
                                                    <li><svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="20" height="20" x="0" y="0" viewBox="0 0 32 32" style="enable-background:new 0 0 512 512" xml:space="preserve" class="hovered-paths"><g><path d="M18.885 7.215h-8.6a1.48 1.48 0 0 1-1.48-1.48V3.48c0-.817.663-1.48 1.48-1.48h8.6c.817 0 1.48.663 1.48 1.48v2.255a1.48 1.48 0 0 1-1.48 1.48zM28.83 17.99c-.92-.92-2.42-.92-3.34 0l-1.092 1.098 3.342 3.341 1.09-1.09c.93-.929.93-2.419 0-3.349zM23.34 20.15l-5.83 5.82c-.12.13-.2.29-.23.46l-.44 2.59c-.1.57.4 1.06.97.97l2.59-.44c.17-.03.33-.11.45-.23l5.83-5.83z" fill="#f7bf39" opacity="1" data-original="#000000" class="hovered-path"></path><path d="M23.11 4.61h-1.245v1.125a2.984 2.984 0 0 1-2.98 2.98h-8.6a2.983 2.983 0 0 1-2.98-2.98V4.61H6.04c-1.97 0-3.57 1.6-3.57 3.57v18.25c0 1.97 1.6 3.57 3.57 3.57h9.457a2.309 2.309 0 0 1-.135-1.238l.439-2.583c.078-.458.288-.881.604-1.226l6.365-6.356 1.655-1.664a3.816 3.816 0 0 1 2.253-1.086V8.19a3.559 3.559 0 0 0-3.568-3.58zM13.028 19.443H8.689a.9.9 0 0 1 0-1.8h4.339a.9.9 0 0 1 0 1.8zm5.312-5.108H8.69a.9.9 0 0 1 0-1.8h9.65a.9.9 0 0 1 0 1.8z" fill="#f7bf39" opacity="1" data-original="#000000" class="hovered-path"></path></g></svg><a href="<?= Url::toRoute(['/article/default/topic', 'slug' => $topic->articlename->slug]) ?>"><?= isset($topic->articlename->title) ? $topic->articlename->title : ''; ?></a></li>
                                            <?php }
                                            } ?>
                                        </ul> -->

                                    </div>
                                    <div class="link"><a href="<?= Url::toRoute(['/article/default/view', 'slug' => $model->slug]) ?>"><i class="fa-solid fa-arrow-right"></i></a></div>
                                </div>
                            </div>
                    <?php }
                    } ?>
                </div>
            </div>
            <div class="col-lg-4 col-xl-3 col-xxl-2 pe-xl-0 ">
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
    </div>
    </div>
</section>
<section class="safariduring_sesons innerpage">
    <?= \frontend\widgets\FeatureParkWidget::widget() ?>
</section>