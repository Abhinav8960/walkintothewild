<?php

use common\interfaces\StatusInterface;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = $safari_operator->businessname . ' | Manage Operator Business';

?>

<div class="container-lg mt-5 mb-5 pt-5 ">
    <div class="row margin_bottomfooter">
        <div class="col-md-12 d-flex justify-content-between mb-4 align-items-center flex-wrap">
            <h6 class="fs-3 fw-bold mb-0"><?= $this->title ?></h6>
            <?php if ($safari_operator->status == StatusInterface::STATUS_ACTIVE) { ?>
                <div class="right_button float-md-end mt-xl-0 mt-3">
                    <a class="btn_newsafari organizeBtn newbg text-center rounded-2  " href="<?= Url::toRoute(['/manage/package/create']) ?>">+ Create New Package </a>
                </div>
            <?php } ?>

        </div>
        <div class="col-xxl-3 col-lg-4 mb-4">
            <?= $this->render('@frontend/modules/manage/views/default/_sidebar', ['active' => 'package']); ?>
        </div>
        <div class="col-xxl-9 col-lg-8">
            <div class="card account-settingside ">
                <div class="card-body p-4">
                    <div class="row">
                        <?php if ($safari_operator->status != StatusInterface::STATUS_ACTIVE) {
                            echo $this->context->module->account_deactivate_message;
                        } ?>
                        <?php
                        Pjax::begin([
                            'id' => 'grid-data',
                            'enablePushState' => FALSE,
                            'enableReplaceState' => FALSE,
                            'timeout' => FALSE,
                        ]);
                        ?>

                        <?php
                        echo $this->render('_search', ['searchModel' => $searchModel]);
                        if ($models = $dataProvider->models) {
                            echo '<div class="row">';
                            foreach ($models as $package) {

                                echo '<div class="col-md-6">';
                                echo $this->render('_package_card', ['model' => $package]);
                                echo '</div>';
                            }
                            echo '</div>';
                        } else {
                            echo 'No Package Created';
                        } ?>
                        <div class="col-md-12 mt-4">
                            <div class="table-responsive table_design_manage">
                                <?= GridView::widget([
                                    'dataProvider' => $dataProvider,
                                    'layout' => '{summary}<br>{pager}',
                                ]); ?>
                            </div>
                        </div>
                        <?php Pjax::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>