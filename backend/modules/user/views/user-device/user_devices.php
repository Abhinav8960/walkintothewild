<?php

use common\models\User;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = 'List of Users With Devices';
$this->params['title'] = $this->title;
?>

<div class="card">
    <div class="card-body">

        <div class="table-responsive">
            <?php Pjax::begin(['id' => 'user-device-grid', 'timeout' => 10000, 'enablePushState' => false]); ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'headerOptions' => ['style' => 'width:5%']
                    ],
                    [
                        'label' => 'IP Address',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->ip_address) ? $model->ip_address : '';
                        }
                    ],
                    [
                        'label' => 'User Platform',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->user_platform) ? $model->user_platform : '';
                        }
                    ],
                    [
                        'label' => 'User Platform Version',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->user_platform_version) ? $model->user_platform_version : '';
                        }
                    ],
                    [
                        'label' => 'User Device',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->user_device) ? $model->user_device : '';
                        }
                    ],
                    [
                        'label' => 'App name',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->app_name) ? $model->app_name : '';
                        }
                    ],
                    [
                        'label' => 'Application Version',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->application_version) ? $model->application_version : '';
                        }
                    ],
                    [
                        'label' => 'Created At',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->created_at) ? $model->created_at : '';
                        }
                    ],

                ],
            ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>