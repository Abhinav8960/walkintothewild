<?php


/* @var $this yii\web\View */

use common\interfaces\Constants;
use common\models\cms\banner\Banner;
use frontend\models\ArticleSearch;

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
        <div class="row mb-4 ">
            <div class="col-lg-8 col-xl-9 col-xxl-9">
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-2 row-cols-xl-2 row-cols-xxl-3  gx-xxl-5 gx-lg-4 ">
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
                                            <li><img src="<?= $this->params['baseurl'] ?>/img/author.png" alt=""><a href=""><?= isset($model->articleAuthor) ? $model->articleAuthor->author_name : '' ?></a></li>
                                            <li><img src="<?= $this->params['baseurl'] ?>/img/comments.png" alt=""><a href=""><?= count($model->articlecomments) ?> Comments</a></li>
                                        </ul>
                                        <h3><a href="/article/<?= $model->slug ?>"><?= $model->title ?> </a></h3>

                                    </div>
                                    <div class="link"><a href="/article/<?= $model->slug ?>"><i class="fa-solid fa-arrow-right"></i></a></div>
                                </div>
                            </div>
                    <?php }
                    } ?>
                </div>
            </div>
            <div class="col-lg-4 col-xl-3 col-xxl-3 ps-xl-5">
                <?= $this->render('recent_posts', [
                    'recentposts' => $recentposts,
                ]) ?>
                <div class="topics_box">
                    <div class="titlerescent pb-3">
                        <h3>Topics</h3>
                    </div>
                    <?= $this->render('_topic_search') ?>
                </div>
            </div>

        </div>
    </div>
    </div>
</section>
<section class="safariduring_sesons innerpage">
    <?= $this->render('park_carousel', [
        'featured_parks' => $featured_parks,
    ]) ?>
</section>