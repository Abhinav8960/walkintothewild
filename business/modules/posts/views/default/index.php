<?php

use yii\helpers\Html;

use yii\widgets\Pjax;
use yii\grid\GridView;
use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\business\assets\PartnerAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$this->title = 'Posts';
// $this->params['breadcrumbs'][] = $this->title;
// $this->params['title'] = $this->title;
// $this->params['buttons'][] = Html::a('+ Create', ['create'], ['class' => 'btn btn-orange float-end', 'title' => 'Create']);
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12 mb-3">
            <div class="selectandsearchmain d-flex justify-content-between align-items-center">
                <div class="search-here position-relative">
                    <input type="search" placeholder="Search" />
                    <a href=""><i class="fa-solid fa-magnifying-glass"></i></a>
                </div>
                <!-- <div>
                    <a class="button-created new" href="">Create</a>
                </div> -->
            </div>
           
        </div>
        <?php foreach ($dataProvider->getModels() as $model) { ?>
            <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-6 col-12 mb-3">
                <div class="sightings-parent-card">
                    <div class="card p-2 border-0">
                        <a href="<?= Url::toRoute(['/posts/default/view', 'id' => $model->id]) ?>"> <img src="<?= Yii::$app->params['s3_endpoint'] . '/' . $model->filepath ?>" class="card-img-top" alt=""></a>
                        <div class="card-body">
                            <p class="mb-0"><?= mb_strimwidth($model->caption, 0, 19, "...") ?></p>
                            <div class="liksMain pt-2 d-flex align-items-center justify-content-between">
                                <div class="likes d-flex align-items-center gap-1">
                                    <a href="<?= Url::toRoute(['/posts/default/view', 'id' => $model->id]) ?>"><img src="<?= $this->params['baseurl'] ?>/images/like.svg" alt=""></a>
                                    <a href="<?= Url::toRoute(['/posts/default/view', 'id' => $model->id]) ?>">
                                        <p class="mb-0"><span><?= $model->like_count ?></span> Likes</p>
                                    </a>
                                </div>
                                <div class="likes d-flex align-items-center gap-1">
                                    <a href="<?= Url::toRoute(['/posts/default/view', 'id' => $model->id]) ?>">
                                        <p class="mb-0"><span><?= $model->comment_count ?></span> Comments</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>