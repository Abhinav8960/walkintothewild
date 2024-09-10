<?php

use frontend\assets\AppAsset;
use frontend\assets\FrontAppAsset;
use frontend\models\ArticleSearch;
use yii\helpers\Html;
use yii\widgets\Pjax;

FrontAppAsset::register($this);
AppAsset::register($this);


$this->title = 'Article';
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



<section class="articals_wrapper py-3">
    <div class="container-lg">
        <div class="row">
            <div class="status-container">
                <div class="status-item <?php echo $article->status == 1 ? 'status-published' : 'status-unpublished'; ?>">
                    <span class="status-label">User Status:</span>
                    <?php echo $article->status == 1 ? "Published" : "UnPublished"; ?>
                    <button class="btn_userarticle" style="background:#F48270 !important;color:black !important;padding: 10px 16px !important;" value="<?= \yii\helpers\Url::toRoute(['/cms/article/articledelete?id=' . $article->id . '']) ?>"><i class="fas fa-trash me-1"></i>Delete</button>
                </div>
                <div class="status-item <?php echo $article->is_approved == 1 ? 'status-published' : 'status-unpublished'; ?>">
                    <span class="status-label">Main Portal Status:</span>
                    <?php echo $article->is_approved == 1 ? "Published" : "UnPublished"; ?>
                    <button class="btn_mainportalarticle" style="background:#F7BF39 !important;color:black !important;padding: 10px 16px !important;" value="<?= \yii\helpers\Url::toRoute(['/cms/article/approval?id=' . $article->id . '']) ?>"><i class="fas fa-edit me-1"></i>Change Status</button>
                </div>
            </div>
        </div>
        <h2 class="mt-2">
            <?= $article->title ?> <a href="<?= Yii::$app->params['frontend_url'] . 'article/' . $article->slug ?>"><img src="<?= $this->params['baseurl'] ?>img/akar-icons_link-out.png"></a>
        </h2>
        <div class="row mb-4 mt-4 justify-content-center">
            <div class="col-lg-8 col-xl-8 col-xxl-8 pe-lg-5">
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
                            <li><i class="fa-solid fa-user"></i><a href="#"><?= isset($article->user) ? $article->user->name : '' ?></a></li>
                            <li><img src="<?= $this->params['baseurl'] ?>/img/comments.png" alt=""><a href=""><?= $article->getArticlecomments()->where(['parent_id' => null, 'status' => 1, 'is_deleted' => 0])->count() ?> Comments</a></li>
                            <li><i class="fa-solid fa-calendar-days"></i><?= date('M d, Y', strtotime($article->article_date)) ?></li>

                        </ul>
                    </div>
                </div>

            </div>
            <div class="col-lg-4 col-xl-4 col-xxl-4 pe-lg-5">
                <div class="recentpost_box mb-5 ">
                    <div class="titlerescent ">
                        <h3 class="mb-0">Top Topics</h3>
                    </div>
                    <div class="row">

                    </div>

                </div>

                <div class="recentpost_box mb-5 ">
                    <div class="titlerescent pb-3">
                        <h3>Similar Articles</h3>
                    </div>
                    <div class="row">

                    </div>

                </div>
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
</section>
<div class="modal fade _standard-text" id="organize-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Change User Status</h1>
                <!-- <button type="button" class="btn_close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button> -->
            </div>
            <div class="modal-body px-2 pt-0">
                <div id='userstatusmodalContent'></div>
            </div>
        </div>
    </div>
</div>

<style>
    .status-container {
        display: flex;
        justify-content: space-between;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #f9f9f9;
    }

    .status-item {
        font-size: 1rem;
        font-weight: bold;
    }

    .status-published {
        color: #28a745;
    }

    .status-unpublished {
        color: #dc3545;
    }

    .status-label {
        margin-right: 5px;
        font-size: 0.9rem;
        color: #333;
    }

    .recentpost_box {
        border: 1px solid gray;
        min-height: 200px;
        background-color: #80808036;
        padding: 0 !important;
    }

    .titlerescent {

        background: #fff;
        padding: 10px;
        border-radius: 10px 10px 0px 0px;
    }
</style>
<?php
$script = <<< JS
function organizefunction() {
	$('.btn_userarticle').on('click', function () {
        $('#organize-modal').modal('show')
		.find('#userstatusmodalContent')
		.load($(this).attr('value'));
	});
}
organizefunction();

JS;
$this->registerJs($script);
?>
<?php
$script = <<< JS
function mainportalfunction() {
	$('.btn_mainportalarticle').on('click', function () {
        $('#organize-modal').modal('show')
		.find('#userstatusmodalContent')
		.load($(this).attr('value'));
	});
}
mainportalfunction();

JS;
$this->registerJs($script);
?>