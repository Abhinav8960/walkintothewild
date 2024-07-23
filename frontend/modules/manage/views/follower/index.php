<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = $safari_operator->business_name . ' | Manage Operator Business';

?>

<div class="container mt-5 mb-5">
    <div class="row mb-5">
        <div class="col-md-12">
            <h5><?= $this->title ?></h5>
        </div>
        <div class="col-md-3">
            <?= $this->render('@frontend/modules/manage/views/default/_sidebar', ['active' => 'follower']); ?>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <?= GridView::widget([
                                    'dataProvider' => $follow_dataProvider,
                                    'columns' => [
                                        [
                                            'class' => 'yii\grid\SerialColumn',
                                            'contentOptions' => ['style' => 'width: 2%;'],
                                        ],
                                        [
                                            'header' => 'User',
                                            'value' => function ($model) {
                                                if ($user = $model->user) {
                                                    return Html::a(Html::img($user->avatar != '' ? $user->avatar : '/img/dpmain.png', ['class' => "rounded profile-picture", 'style' => "width:28px;"]) . ' ' . $user->name, ['/profile/default/index', 'user_handle' => $user->user_handle]);
                                                }
                                                return $model->user_id;
                                            },
                                            'format' => 'raw',
                                        ],
                                        [
                                            'label' => 'Follow Start Time',
                                            'value' => function ($model) {
                                                return $model->follow_datetime;
                                            }
                                        ],
                                        [
                                            'label' => 'IP Address',
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return $model->user_ip_address;
                                            }
                                        ],
                                        // [
                                        //     'label' => 'OS/Platform',
                                        //     'format' => 'raw',
                                        //     'value' => function ($model) {
                                        //         return $model->user_platform;
                                        //     }
                                        // ],
                                        // [
                                        //     'label' => 'Browser',
                                        //     'format' => 'raw',
                                        //     'value' => function ($model) {
                                        //         return $model->user_browser;
                                        //     }
                                        // ],
                                        // [
                                        //     'label' => 'Deview',
                                        //     'format' => 'raw',
                                        //     'value' => function ($model) {
                                        //         return $model->user_device;
                                        //     }
                                        // ],
                                    ],
                                ]); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>