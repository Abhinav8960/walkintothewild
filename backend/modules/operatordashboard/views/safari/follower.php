<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Safari Tour - Follower';
$this->params['breadcrumbs_home_url'] = '/operatordashboard';
$this->params['breadcrumbs'][] =  ['label' => 'Operator', 'url' => '#'];
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
?>

<div class="panel panel-primary tabs-style-2">
    <?= $this->render('_navbar', ['safari_operator' => $safari_operator, 'active_navbar' => 'follower']) ?>
    <div class="panel-body tabs-menu-body main-content-body-right border">
        <div class="tab-content">
            <div class="tab-pane active">
                <div class="table-responsive">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => [
                            [
                                'class' => 'yii\grid\SerialColumn',
                                'contentOptions' => ['style' => 'width: 2%;'],
                            ],
                            [
                                'header' => 'User',
                                'value' => function ($model) {
                                    if ($user = $model->user) {
                                        return Html::img($user->avatar != '' ? $user->avatar : '/img/dpmain.png', ['class' => "rounded profile-picture", 'style' => "width:28px;"]) . ' ' . $user->name;
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
                            [
                                'label' => 'OS/Platform',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->user_platform;
                                }
                            ],
                            [
                                'label' => 'Browser',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->user_browser;
                                }
                            ],
                            [
                                'label' => 'Deview',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->user_device;
                                }
                            ],
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>