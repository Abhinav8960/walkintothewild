<?php

use common\interfaces\StatusInterface;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
$this->title = $safari_operator->businessname . ' | Manage Operator Business';

?>

<div class="container-lg mt-5 mb-5 pt-5">
    <div class="row margin_bottomfooter">
        <div class="col-md-12 d-flex justify-content-between mb-4 align-items-center flex-wrap">
            <h6 class="fs-3 fw-bold mb-0"><?= $this->title ?></h6>
            <?php if ($safari_operator->status == StatusInterface::STATUS_ACTIVE) { ?>
                <div class="d-flex justify-content-between mt-xl-0 mt-3">
                    <a href="<?= Url::toRoute(['/manage/article/create']) ?>" class="btn_newsafari organizeBtn newbg text-center rounded-2 px-3 py-2"><i class="fa fa-plus"></i> Create Article</a> &nbsp;
                </div>
            <?php } ?>
        </div>
        <div class="col-xxl-3 col-lg-4 mb-4">
            <?= $this->render('@frontend/modules/manage/views/default/_sidebar', ['active' => 'article']); ?>
        </div>
        <div class="col-xxl-9 col-lg-8">
            <div class="card account-settingside">
                <div class="card-body p-4">
                    <div class="row">
                        <?php if ($safari_operator->status != StatusInterface::STATUS_ACTIVE) {
                            echo $this->context->module->account_deactivate_message;
                        } ?>
                        <?php if ($models = $dataProvider->models) {
                            foreach ($models as $featured_article) { ?>
                                <div class="col-xxl-4 col-lg-6 col-md-6 col-sm-6 mb-5">
                                    <div class="artical_cards h-100">
                                        <div class="image-box">
                                            <figure class="image"><img src="<?= isset($featured_article->banner_image) ? $featured_article->bannerimagepath : $this->params['baseurl'] . '/img/Article1.jpg' ?>" alt="">
                                            </figure>
                                        </div>
                                        <div class="lower-content">
                                            <ul class="artical-info ">
                                                <li><i class="fa-solid fa-user"></i><?= isset($featured_article->articleAuthor) ? $featured_article->articleAuthor->author_name : '' ?></li>
                                            </ul>
                                            <h3><?= $featured_article->title ?> </h3>

                                            <div class="artical-info justify-content-center">
                                                <img src="<?= $this->params['baseurl'] ?>/img/comments.png" alt=""> <?= $featured_article->getArticlecomments()->where(['status' => 1])->count() ?> Comments
                                                <span style="color: #9C9C9C;"><i class="fa-solid fa-calendar-days me-1" style="color:#f9d600;"></i><?= date('M d, Y', strtotime($featured_article->article_date)) ?></span>
                                            </div>

                                        </div>
                                        <div class="link"><a href="<?= Url::toRoute(['/manage/article/update', 'slug' => $featured_article->slug]) ?>" data-pjax="0"><i class="fa-solid fa-edit"></i></a></div>
                                    </div>
                                </div>
                        <?php  }
                        } else {
                            echo 'No Article Created';
                        } ?>
                        <div class="col-md-12">
                            <div class="table-responsive table_design_manage">
                                <?= GridView::widget([
                                    'dataProvider' => $dataProvider,
                                    'layout' => '{summary}<br>{pager}',
                                ]); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>