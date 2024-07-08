<?php

use yii\helpers\Url;

?>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="title_web">
                <h2>ARTICLES AND TIPS</h2>
            </div>
        </div>
    </div>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-3 row-cols-xl-3 row-cols-xxl-4  gx-xxl-5 gx-lg-4 padding-setDes padding_left px-sm-2">
        <?php if ($featured_articles) {
            foreach ($featured_articles as $featured_article) { ?>
                <div class="col mb-5">
                    <div class="artical_cards h-100">
                        <div class="image-box">
                            <figure class="image"><a href="/article/<?= $featured_article->slug ?>"><img src="<?= isset($featured_article->feature_image) ? $featured_article->featureimagepath : $this->params['baseurl'] . '/img/Article1.jpg' ?>" alt=""></a>
                            </figure>
                        </div>
                        <div class="lower-content">
                            <ul class="artical-info ">
                                <li><i class="fa-solid fa-user"></i><a href="<?= Url::toRoute(['/article/default/author', 'slug' => $featured_article->articleAuthor ? $featured_article->articleAuthor->slug : '']) ?>"><?= isset($featured_article->articleAuthor) ? $featured_article->articleAuthor->author_name : '' ?></a></li>
                            </ul>
                            <h3><a href="<?= Url::toRoute(['/article/default/view', 'slug' => $featured_article->slug]) ?>"><?= $featured_article->title ?> </a></h3>

                            <div class="artical-info justify-content-center">
                                <a href="<?= Url::toRoute(['/article/default/view', 'slug' => $featured_article->slug, '#' => 'comment-wrapper-section']) ?>" style="color: #9C9C9C;"><img src="<?= $this->params['baseurl'] ?>/img/comments.png" alt=""> <?= $featured_article->getArticlecomments()->where(['status' => 1])->count() ?> Comments</a>

                                <span style="color: #9C9C9C;"><i class="fa-solid fa-calendar-days me-1" style="color:#f9d600;"></i><?= date('M d, Y', strtotime($featured_article->article_date)) ?></span>
                            </div>

                        </div>
                        <div class="link"><a href="<?= Url::toRoute(['/article/default/view', 'slug' => $featured_article->slug]) ?>"><i class="fa-solid fa-arrow-right"></i></a></div>
                    </div>
                </div>
        <?php  }
        } ?>
    </div>
</div>