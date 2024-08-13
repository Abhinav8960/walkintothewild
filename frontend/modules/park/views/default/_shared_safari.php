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

<section>
    <?= $this->render('@frontend/modules/park/views/default/tablist', [
        'share_safari' => 'active',
        'model' => $model,
    ]) ?>
</section>
<section class="">
    <div class="container-fluid">
        <div class="row my-lg-4 my-2 pt-3 justify-content-center margin_bottomfooter mb-5">
            <div class="col-lg-12 col-xxl-11">
                <div class="row">
                    <div class="col-12 mb-3">
                        <?php if ($shared_safaries = $dataProvider->models) { ?>
                            <div class="backgroud_oprator">
                                <!-- <div class="title_safari JoinPadding d-flex justify-content-center justify-content-xl-between align-items-center flex-wrap">
                                        <h4 class="text-center py-2">Join Shared Safaris in <?= isset($model->title) ? $model->title : '' ?></h4>
                                    </div> -->
                                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 row-cols-xxl-4 gx-xxl-2 g-xl-4 gx-xxl-5 ">
                                    <?php foreach ($shared_safaries as $share_safari) { ?>
                                        <div class="col mb-xl-0 mb-3 ">
                                            <?= $this->render('@frontend/modules/sharedsafari/views/default/_shared_safari_card', ['share_safari' => $share_safari]) ?>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php } ?>

                        <?php
                        echo \yii\widgets\LinkPager::widget([
                            'pagination' => $dataProvider->pagination,
                        ]);
                        ?>
                    </div>
                </div>
            </div>

        </div>
    </div>

</section>