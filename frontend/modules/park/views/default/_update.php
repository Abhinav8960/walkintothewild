<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use common\models\GeneralModel;
use common\interfaces\Constants;
use common\models\cms\banner\Banner;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
?>

<section class="articals_wrapper py-3 " style="background-color: #fff;">
    <div class="container-fluid">
        <?= $this->render('@frontend/modules/park/views/default/tablist', [
            'update' => 'active',
            'model' => $model,
        ]) ?>
    </div>
</section>

<div class="row my-lg-4 my-2 justify-content-center margin_bottomfooter mb-5">
    <div class="col-lg-12 col-xl-10">
        <div class="row">
            <div class="col-12 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h1>Update</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

