<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use common\models\GeneralModel;
use common\interfaces\Constants;
use common\models\cms\banner\Banner;


/* @var $this yii\web\View */

$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$park_constant = Constants::PARK_VIEW;
$banner = Banner::find()->where(['status' => 1, 'page_id' => $park_constant])->limit(1)->one();

if ($model->meta_description != '') {
    $this->params['meta_description'] = $model->meta_description;
}

if ($model->meta_keywords != '') {
    $this->params['meta_keywords'] = $model->meta_keywords;
}
if ($model->meta_title != '') {
    $this->title = $model->meta_title;
} else {
    $this->title = 'Safari ' . $model->title;
}
?>



<section class="articals_wrapper py-3 " style="background-color: #fff;">
    <div class="container-fluid">

        <?= $this->render('@frontend/modules/park/views/default/tablist', [
            'operator' => 'active',
            'model' => $model,
        ]) ?>
    </div>
</section>

<div class="row my-lg-4 my-2 justify-content-center margin_bottomfooter mb-5">
    <div class="col-lg-12 col-xl-10">
        <div class="card">
            <div class="card-body">
                <?= $this->render('_operators', [
                    'operators' => $operators,
                    'model' => $model,
                    'operatorsearchModel' => $operatorsearchModel,
                    'shared_safaries' => $shared_safaries,
                    'device' => $device,
                    'reviews' => $reviews
                ]) ?></div>
        </div>

    </div>

</div>