<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use common\models\GeneralModel;
use common\interfaces\Constants;
use common\models\cms\banner\Banner;
use common\models\UserWishlist;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
?>

<section style="background-color: #fff;">

    <?= $this->render('@frontend/modules/park/views/default/tablist', [
        'package' => 'active',
        'model' => $model,
    ]) ?>

</section>
<section class="">
    <div class="container-fluid">
        <div class="row my-lg-4 my-2 pt-3 justify-content-center margin_bottomfooter mb-5">
            <div class="col-lg-12 col-xxl-11 mb-3">
                <div class="card card_bodyPadding">
                    <div class="card-body">
                        <?php if ($packages) { ?>
                            <div class="backgroud_oprator py-4">

                                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-2 row-cols-xl-3 row-cols-xxl-4 gx-xxl-2 g-xl-4 gx-xxl-4 ">

                                    <?php
                                    foreach ($packages as $model) { ?>
                                        <div class="col mb-4 padding_righ">
                                            <?= $this->render('@frontend/modules/package/views/default/_package_card', ['model' => $model]) ?>
                                        </div>

                                    <?php
                                    } ?>
                                </div>
                            </div>
                        <?php } else {
                            echo '<div class="justify-content-between flex-wrap bg-white">No Package Found</div>';
                        } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>