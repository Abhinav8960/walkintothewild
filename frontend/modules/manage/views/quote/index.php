<?php

use yii\grid\GridView;

$this->title = $safari_operator->businessname . ' | Manage Operator Business';

?>

<div class="container-fluid mt-5 ">
    <div class="row margin_bottomfooter">
        <div class="col-md-12">
            <h6 class="fs-3 fw-bold mb-4"><?= $this->title ?></h6>
        </div>
        <div class="col-md-3 col-xl-2 col-xxl-2 mb-3">
            <?= $this->render('@frontend/modules/manage/views/default/_sidebar', ['active' => 'quote']); ?>
        </div>
        <div class="col-md-9 col-xl-10 col-xxl-10">
            <div class="card account-settingside">
                <div class="card-body p-4">
                    <div class="row">
                        <?php if ($models = $dataProvider->models) {
                            foreach ($models as $model) {
                                $park_detail = $model->park;
                                if (!$park_detail) {
                                    continue;
                                }
                        ?>
                                <div class="col-md-3 col-sm-6 col-lg-3 gap-2 mt-2 mb-2">
                                    <div class="parksImgireview h-100 position-relative">
                                        <img src="<?= isset($park_detail->logoimagepath) ? $park_detail->logoimagepath : $this->params['baseurl'] . '/img/Bandhavgarhbig.jpg' ?>" alt="" class="w-100 h-100">
                                        <div class="footer_safariname">
                                            <h5 class="text-white"><?= $park_detail->title ?></h5>
                                            <div class="row text-white">
                                                <div class="col-6 mt-2">
                                                    <?= $model->full_name ?>
                                                </div>
                                                <div class="col-6 mt-2">
                                                    <?= $model->email ?>
                                                </div>
                                                <div class="col-6 mt-2">
                                                    Safaris : <?= $model->safaris ?>
                                                </div>
                                                <div class="col-6 mt-2">
                                                    Travelers : <?= $model->travelers ?>
                                                </div>
                                                <div class="col-12 mt-2">
                                                    Stay Category : <?= $model->staycatgory ? $model->staycatgory->title : '' ?>
                                                </div>
                                                <div class="col-6 mt-2">
                                                    <?= $model->start_date ?>
                                                </div>
                                                <div class="col-6 mt-2">
                                                    <?= $model->end_date ?>
                                                </div>
                                                <div class="col-12 mt-2">
                                                    <?= Yii::$app->formatter->format($model->created_at, 'relativeTime') ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        <?php }
                        } else {
                            echo 'NO Quote Request Recivied';
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