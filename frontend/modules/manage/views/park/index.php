<?php

use yii\helpers\Url;

$this->title = $safari_operator->businessname . ' | Manage Operator Business';

?>

<div class="container-fluid mt-5 ">
    <div class="row margin_bottomfooter">
        <div class="col-md-12">
            <h6 class="fs-3 fw-bold mb-4"><?= $this->title ?></h6>
        </div>
        <div class="col-md-3 col-xl-2 col-xxl-2 mb-3">
            <?= $this->render('@frontend/modules/manage/views/default/_sidebar', ['active' => 'park']); ?>
        </div>
        <div class="col-md-9 col-xl-10 col-xxl-10">
            <div class="card account-settingside">
                <div class="card-body p-4">
                    <div class="row">
                        <?php foreach ($operator_parks as $operator_park) {
                            $park_detail = $operator_park->park;
                        ?>
                            <div class="col-md-6 col-sm-6 col-lg-3 col-xxl-2 col-xl-3 gap-2 mt-2 mb-2">
                                <div class="parksImgireview h-100 position-relative">
                                    <a href="<?= \yii\helpers\Url::toRoute(['/park/default/view', 'slug' =>  $park_detail->slug]) ?>" data-pjax="0">
                                        <img src="<?= isset($park_detail->logoimagepath) ? $park_detail->logoimagepath : $this->params['baseurl'] . '/img/Bandhavgarhbig.jpg' ?>" alt="" class="w-100 h-100">
                                    </a>
                                    <div class="footer_safariname">
                                        <h6 class=""><?= $park_detail->title ?></h6>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>