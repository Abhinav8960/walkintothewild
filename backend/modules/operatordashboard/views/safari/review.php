<?php

use yii\grid\GridView;

$this->title = 'Safari Tour - User Review';
$this->params['breadcrumbs_home_url'] = '/operatordashboard';
$this->params['breadcrumbs'][] =  ['label' => 'Operator', 'url' => '#'];
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
?>

<div class="panel panel-primary tabs-style-2">
    
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
                            'park.title:raw:Park Name',
                            'user.name',
                            [
                                'label' => 'Rating',
                                'contentOptions' => ['style' => 'width: 10%;'],
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->rating;
                                }
                            ],
                            [
                                'label' => 'Review',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->review;
                                }
                            ],
                            [
                                'label' => 'IP Address',
                                'contentOptions' => ['style' => 'width: 5%;'],
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->user_ip_address;
                                }
                            ],
                            [
                                'label' => 'OS/Platform',
                                'contentOptions' => ['style' => 'width: 5%;'],
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->user_platform;
                                }
                            ],
                            [
                                'label' => 'Browser',
                                'contentOptions' => ['style' => 'width: 5%;'],
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->user_browser;
                                }
                            ],
                            [
                                'label' => 'Deview',
                                'contentOptions' => ['style' => 'width: 5%;'],
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->user_device;
                                }
                            ],
                            [
                                'label' => 'Review Time',
                                'contentOptions' => ['style' => 'width: 5%;'],
                                'format' => 'dateTime',
                                'value' => function ($model) {
                                    return $model->created_at;
                                }
                            ],
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>