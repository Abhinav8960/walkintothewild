<?php
$this->title = 'Notifications';

use yii\helpers\Url;
use yii\grid\GridView;
?>

<div class="container mt-5">
    <div class="row margin_bottomfooter">
        <div class="col-12 d-flex align-items-center justify-content-between mb-4">
            <h6 class="fs-3 fw-bold ">Notifications</h6>
        </div>
        <div class="col-md-6 offset-md-3">
            <div class="card account-settingside" style="min-height:500px">
                <div class="card-body p-4">
                    <h6 class="fs-5 fw-bold mb-3"> Recivied Notifications</h6>
                    <?php if ($models = $dataProvider->models) {
                        foreach ($models as $model) { ?>
                            <a href="<?= Url::toRoute(['/account/notification/view', 'id' => $model->id]) ?>" style="color:inherit;">
                                <div class="row p-3 shadow-sm  bg-white rounded mb-3 <?= $model->noticeclass ?>">
                                    <div class="col-9">
                                        <?= $model->notification_text ?>
                                    </div>
                                    <div class="col-3 d-flex justify-content-end">
                                        <span><?= Yii::$app->formatter->format($model->created_at, 'relativeTime') ?></span>
                                    </div>
                                </div>
                            </a>
                    <?php }
                    }  ?>
                </div>
            </div>

            <div class="mt-3 table-footer d-flex justify-content-between align-items-center mb-3">
                <div class="col-md-12">
                    <?php echo GridView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => '{summary}<br>{pager}',
                        'columns' => [],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>