<?php

use frontend\assets\AppAsset;
use frontend\assets\FrontAppAsset;
use frontend\models\ArticleSearch;
use yii\helpers\Html;
use yii\widgets\Pjax;

FrontAppAsset::register($this);
AppAsset::register($this);


$this->title = $article->title;
$this->params['breadcrumbs_home_url'] = '/';
$this->params['breadcrumbs'][] =  ['label' => 'Article', 'url' => '/cms/article'];
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
$recentposts = ArticleSearch::recentpost();
$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
// $this->params['baseurl'] = $webasset->baseUrl;
?>


<?php Pjax::begin([
    'id' => 'grid-data',
    'enablePushState' => false,
    'enableReplaceState' => false,
    'timeout' => false,
]); ?>


<div class="row">
    <span>
        <h6>User Status: <?php
                            if ($article->status == 1) {
                                echo "Published";
                            } else {
                                echo "UnPublished";
                            } ?></h6>
    </span>
    <span>
        <h6>Main Portal Status: <?php if ($article->is_approved == 1) {
                                    echo "Published";
                                } else {
                                    echo "UnPublished";
                                } ?></h6>
    </span>
    <span>
        <?php echo Html::a(
            '<img src="' . $this->params['baseurl'] . '/img/update.png" alt="" width="25" height="25">',
            ['approval', 'id' => $article->id],
            [
                'class' => 'btn p-0 change-menuicon',
                'title' => 'update',
            ]
        ); ?>
    </span>
    <span>
        <?php echo Html::a(
            '<img src="' . $this->params['baseurl'] . '/img/delete.png" alt="" width="25" height="25">',
            ['articledelete', 'id' => $article->id],
            [
                'class' => 'btn p-0 change-menuicon',
                'title' => 'Delete',
                'data' => [
                    'confirm' => 'Are you sure you want to delete ' . $article->title . '?',
                    'method' => 'post',
                ],
            ]
        ); ?>
    </span>
</div>

<section class="articals_wrapper py-3">
    <div class="container-lg">
        <div class="row mb-4 justify-content-center">
            <div class="col-lg-12 col-xl-12 col-xxl-12 pe-lg-5">
                <div class="aritcla-details">
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
                                    <li><svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="20" height="20" x="0" y="0" viewBox="0 0 32 32" style="enable-background:new 0 0 512 512" xml:space="preserve" class="hovered-paths">
                                            <g>
                                                <path d="M18.885 7.215h-8.6a1.48 1.48 0 0 1-1.48-1.48V3.48c0-.817.663-1.48 1.48-1.48h8.6c.817 0 1.48.663 1.48 1.48v2.255a1.48 1.48 0 0 1-1.48 1.48zM28.83 17.99c-.92-.92-2.42-.92-3.34 0l-1.092 1.098 3.342 3.341 1.09-1.09c.93-.929.93-2.419 0-3.349zM23.34 20.15l-5.83 5.82c-.12.13-.2.29-.23.46l-.44 2.59c-.1.57.4 1.06.97.97l2.59-.44c.17-.03.33-.11.45-.23l5.83-5.83z" fill="#f7bf39" opacity="1" data-original="#000000" class="hovered-path"></path>
                                                <path d="M23.11 4.61h-1.245v1.125a2.984 2.984 0 0 1-2.98 2.98h-8.6a2.983 2.983 0 0 1-2.98-2.98V4.61H6.04c-1.97 0-3.57 1.6-3.57 3.57v18.25c0 1.97 1.6 3.57 3.57 3.57h9.457a2.309 2.309 0 0 1-.135-1.238l.439-2.583c.078-.458.288-.881.604-1.226l6.365-6.356 1.655-1.664a3.816 3.816 0 0 1 2.253-1.086V8.19a3.559 3.559 0 0 0-3.568-3.58zM13.028 19.443H8.689a.9.9 0 0 1 0-1.8h4.339a.9.9 0 0 1 0 1.8zm5.312-5.108H8.69a.9.9 0 0 1 0-1.8h9.65a.9.9 0 0 1 0 1.8z" fill="#f7bf39" opacity="1" data-original="#000000" class="hovered-path"></path>
                                            </g>
                                        </svg><a href="#"><?= isset($topic->articlename->title) ? $topic->articlename->title : ''; ?></a></li>
                            <?php }
                            } ?>


                        </ul>
                    </div>
                </div>
                <div class="tags-wrapper  my-5 d-flex justify-content-between flex-wrap align-items-center">
                    <div class="d-flex align-items-center">
                        <h3 class="me-4 mb-0 tags-title">Tags</h3>
                        <?= $this->render('_tag_search', [
                            'article' => $article,
                        ]) ?>
                    </div>
                    <div class="author_wrapper">
                        <ul class="artical-info ">
                            <li><i class="fa-solid fa-user"></i><a href="#"><?= isset($article->articleAuthor) ? $article->articleAuthor->author_name : '' ?></a></li>
                            <li><img src="<?= $this->params['baseurl'] ?>/img/comments.png" alt=""><a href=""><?= $article->getArticlecomments()->where(['status' => 1])->count() ?> Comments</a></li>
                            <li><i class="fa-solid fa-calendar-days"></i><?= date('M d, Y', strtotime($article->article_date)) ?></li>

                        </ul>
                    </div>
                </div>
                <div class="comment-wrapper" id="comment-wrapper-section">
                    <?= $this->render('_comment', [
                        'article' => $article,
                        'dataProvider' => $dataProvider,
                        'searchModel' => $searchModel,
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</section>