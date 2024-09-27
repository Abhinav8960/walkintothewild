<?php

use common\models\User;
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Login Users';
$this->params['breadcrumbs_home_url'] = '/user/login-user/index';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
?>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'label' => 'Full Name',
                        'contentOptions' => ['style' => 'width: 15%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            $user = $model->user;
                            if($user){
                                return '<img src="' . ($user->profileimage ? $user->profileimage : $this->params['baseurl'] . '/img/user.png') . '" alt="" style="height:25px;" class="rounded-circle user-icon" onerror="this.src="' . $this->params['baseurl'] . '/img/Share-Safari/dpmain.png' . '";"> ' . $model->user->name;
                            }
                        }
                    ],
                    [
                        'label' => 'Application',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->app_name;
                        }
                    ],
                    [
                        'label' => 'IP Address',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->ip_address;
                        }
                    ],
                    [
                        'label' => 'User Device',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->user_device;
                        }
                    ],
                    [
                        'label' => 'User Platform',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->user_platform;
                        }
                    ],
                    [
                        'label' => 'User Browser',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->user_browser;
                        }
                    ],
                    'created_at:raw:Session Start at',
                    'last_activity:raw:Last Active at',
                    [
                        'label' => 'Destroy Session',
                        'value' => function ($model) {
                            return Html::a('<i class="fa fa-ban text-white"></i>', ['destory', 'session_id' => $model->id], ['class' => 'btn btn-danger', 'title' => 'Destory User Session', 'data-bs-toggle' => "tooltip"]);
                        },
                        'format' => 'raw',
                        'headerOptions' => ['style' => 'width:5%;'],
                        'contentOptions' => ['style' => 'width:5%;'],
                    ],
                    // [
                    //     'label' => 'User Agent',
                    //     'format' => 'raw',
                    //     'value' => function ($model) {
                    //         return $model->user_agent;
                    //     }
                    // ],
                ],
            ]); ?>
        </div>
    </div>
</div>