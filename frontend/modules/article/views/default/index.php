<?php


/* @var $this yii\web\View */

use common\interfaces\Constants;
use common\models\cms\banner\Banner;

$this->title = 'Article';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
$park_constant = Constants::ARTICLE_LISTING;
$banner = Banner::find()->where(['status' => 1, 'page_id' => $park_constant])->limit(1)->one();
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
        <div class="row mb-4">
            <div class="col-lg-9">
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-2 row-cols-xl-3 row-cols-xxl-3  gx-xxl-5 gx-lg-4">
                    <?php if ($models) {
                        foreach ($models as $model) { ?>
                            <div class="col mb-5">
                                <div class="artical_cards h-100">
                                    <div class="image-box">
                                        <figure class="image"><a href=""><img src="<?= isset($model->feature_image) ? $model->featureimagepath : $this->params['baseurl'] . '/img/Article1.jpg' ?>" alt=""></a>
                                        </figure>
                                    </div>
                                    <div class="lower-content">
                                        <ul class="artical-info ">
                                            <li><img src="<?= $this->params['baseurl'] ?>/img/author.png" alt=""><a href=""><?= isset($model->articleAuthor) ? $model->articleAuthor->author_name : '' ?></a></li>
                                            <li><img src="<?= $this->params['baseurl'] ?>/img/comments.png" alt=""><a href=""><?= count($model->articlecomments) ?> Comments</a></li>
                                        </ul>
                                        <h3><a href=""><?= $model->title ?> </a></h3>

                                    </div>
                                    <div class="link"><a href=""><i class="fa-solid fa-arrow-right"></i></a></div>
                                </div>
                            </div>
                    <?php }
                    } ?>
                </div>
            </div>
            <div class="col-lg-3 ">
                <div class="recentpost_box mb-5 ">
                    <div class="titlerescent pb-3">
                        <h3>Recent Posts</h3>
                    </div>
                    <div class="recent-posts mb-4">
                        <div class="row">
                            <div class="col-3">
                                <div class="postthumbnail">
                                    <a href=""><img src="<?= $this->params['baseurl'] ?>/img/Article1.jpg" alt="" class="w-100"></a>
                                </div>
                            </div>
                            <div class="col-9">
                                <div class="posttitles">
                                    <h6><a href="">How to Plan Your First Wildlife Safari</a></h6>
                                </div>
                                <ul class="artical-info p-0 justify-content-start gap-1 mb-0">
                                    <li class="d-flex align-items-center gap-2"><i class="far fa-comments"></i><a href="">3 Comments</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="recent-posts mb-4">
                        <div class="row">
                            <div class="col-3">
                                <div class="postthumbnail">
                                    <a href=""><img src="<?= $this->params['baseurl'] ?>/img/Article2.jpg" alt="" class="w-100"></a>
                                </div>
                            </div>
                            <div class="col-9">
                                <div class="posttitles">
                                    <h6><a href="">How to Plan Your First Wildlife Safari</a></h6>
                                </div>
                                <ul class="artical-info p-0 justify-content-start gap-1 mb-0">
                                    <li class="d-flex align-items-center gap-2"><i class="far fa-comments"></i><a href="">3 Comments</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="recent-posts mb-4">
                        <div class="row">
                            <div class="col-3">
                                <div class="postthumbnail">
                                    <a href=""><img src="<?= $this->params['baseurl'] ?>/img/Article3.jpg" alt="" class="w-100"></a>
                                </div>
                            </div>
                            <div class="col-9">
                                <div class="posttitles">
                                    <h6><a href="">How to Plan Your First Wildlife Safari</a></h6>
                                </div>
                                <ul class="artical-info p-0 justify-content-start gap-1 mb-0">
                                    <li class="d-flex align-items-center gap-2"><i class="far fa-comments"></i><a href="">3 Comments</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="recent-posts mb-4">
                        <div class="row">
                            <div class="col-3">
                                <div class="postthumbnail">
                                    <a href=""><img src="<?= $this->params['baseurl'] ?>/img/Article4.jpg" alt="" class="w-100"></a>
                                </div>
                            </div>
                            <div class="col-9">
                                <div class="posttitles">
                                    <h6><a href="">How to Plan Your First Wildlife Safari</a></h6>
                                </div>
                                <ul class="artical-info p-0 justify-content-start gap-1 mb-0">
                                    <li class="d-flex align-items-center gap-2"><i class="far fa-comments"></i><a href="">3 Comments</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="topics_box">
                    <div class="titlerescent pb-3">
                        <h3>Topics</h3>
                    </div>
                    <div class="topics_listing">
                        <ul>
                            <li><a href="">Wildlife <i class="fa-solid fa-chevron-right"></i></a></li>
                            <li><a href="">Safari <i class="fa-solid fa-chevron-right"></i></a></li>
                            <li><a href="">Animals <i class="fa-solid fa-chevron-right"></i></a></li>
                            <li><a href="">Birds <i class="fa-solid fa-chevron-right"></i></a></li>
                            <li><a href="">Gadgets <i class="fa-solid fa-chevron-right"></i></a></li>
                            <li><a href="">Wildlife <i class="fa-solid fa-chevron-right"></i></a></li>
                        </ul>
                    </div>
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