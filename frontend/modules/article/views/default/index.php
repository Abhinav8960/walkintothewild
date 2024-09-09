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
$active_url = "/" . Yii::$app->requestedRoute;

if (isset($slug) && $slug != '' && in_array($active_url, array("/article/default/topic"))) {
    $recentposts = ArticleSearch::recentpost($slug);
} else {
    $recentposts = ArticleSearch::recentpost();
}

?>

<section class="banner_section-inner packagebnner position-relative">
    <picture class="position-relative">
        <source srcset="<?= isset($banner->image) ? $banner->imagepath : $this->params['baseurl'] . '/img/articlebanner.png' ?>" media="(max-width:576px)" type="image/webp">
        <img src="<?= isset($banner->image) ? $banner->imagepath : $this->params['baseurl'] . '/img/articlebanner.png' ?>" class="d-block w-100 banner_search" alt="banner">
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

<section class="articals_wrapper py-3 margin_bottomfooter ">
    <div class="container-fluid">
        <div class="advertisment mt-5">
            <div class="google-ad-box  mb-5">

            </div>
        </div>
        <div class="row mb-4  justify-content-center">
            <div class="col-xl-12 col-lg-12">
                <div class="row justify-content-center gx-xl-5">
                    <div class="col-lg-8 col-xl-8 col-xxl-9 ps-xl-0">
                        <?php if (isset($sub_title)) { ?>
                            <div class="topics_tags">
                                <p class="fs-3 pb-3 mb-3 mt-2" style="font-style: italic;"><?= isset($sub_title) ? $sub_title : '' ?></p>
                            </div>
                        <?php } ?>
                        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-2 row-cols-xl-2 row-cols-xxl-3  gx-xxl-5 gx-lg-4 ">
                            <?php if ($models) {
                                foreach ($models as $model) { ?>
                                    <div class="col mb-5">
                                        <div class="artical_cards h-100">
                                            <div class="image-box">
                                                <figure class="image"><a href="/article/<?= $model->slug ?>"><img src="<?= isset($model->banner_image) ? $model->bannerimagepath : $this->params['baseurl'] . '/img/Article1.jpg' ?>" alt=""></a>
                                                </figure>
                                            </div>
                                            <div class="lower-content">
                                                <ul class="artical-info ">
                                                    <li><i class="fa-solid fa-user"></i><a href="<?= Url::toRoute(['/profile/article/index', 'user_handle' => isset($model->user) ? $model->user->user_handle : '']) ?>"><?= isset($model->user) ? $model->user->name : '' ?></a></li>

                                                </ul>
                                                <h3><a href="<?= Url::toRoute(['/article/default/view', 'slug' => $model->slug]) ?>"><?= $model->title ?> </a></h3>

                                                <div class="artical-info justify-content-center">
                                                    <a href="<?= Url::toRoute(['/article/default/view', 'slug' => $model->slug, '#' => 'comment-wrapper-section']) ?>" style="color: #9C9C9C;"><img src="<?= $this->params['baseurl'] ?>/img/comments.png" alt=""> <?= $model->getArticlecomments()->where(['status' => 1])->count() ?> Comments</a>

                                                    <span style="color: #9C9C9C;"><i class="fa-solid fa-calendar-days me-1" style="color:#f9d600;"></i><?= date('M d, Y', strtotime($model->article_date)) ?></span>
                                                </div>


                                            </div>
                                            <div class="link"><a href="<?= Url::toRoute(['/article/default/view', 'slug' => $model->slug]) ?>"><i class="fa-solid fa-arrow-right"></i></a></div>
                                        </div>
                                    </div>
                            <?php }
                            } ?>
                        </div>
                    </div>
                    <div class="col-lg-3 col-xl-3 col-xxl-2 pe-xl-0 ">
                        <?= $this->render('_recent_posts', [
                            'recentposts' => $recentposts,
                        ]) ?>
                        <div class="topics_box">
                            <div class="titlerescent pb-3">
                                <h3>Category</h3>
                            </div>
                            <?= $this->render('_topic_search') ?>
                        </div>

                        <div class="advertisment d-lg-block d-none mt-5">
                            <div class="google-ad300  mb-5">

                            </div>
                        </div>
                        <div class="advertisment d-lg-block d-none ">
                            <div class="google-add600hight  mb-5">

                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
    </div>
</section>