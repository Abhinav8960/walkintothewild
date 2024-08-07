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

<section >
        <?= $this->render('@frontend/modules/park/views/default/tablist', [
            'discussion' => 'active',
            'model' => $model,
        ]) ?>  
</section>

<div class="row my-lg-4 my-2 pt-3 px-lg-5 px-3 justify-content-center margin_bottomfooter mb-5">
    <div class="col-lg-12 col-xxl-11">
        <div class="row">
            <div class="col-12 mb-3">
                <div class="card card_bodyPadding">
                    <div class="card-body">
                        <h6 class="fs-5 fw-bold">Discussion</h6>
                    </div>
                </div>


            </div>
        </div>
    </div>

</div>