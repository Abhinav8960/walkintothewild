<?php

use yii\grid\GridView;

$this->title = 'Safari Tour - Get a Free Quote';
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
                            [
                                'label' => 'Name',
                                'contentOptions' => ['style' => 'width: 10%;'],
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->full_name;
                                }
                            ],
                            [
                                'label' => 'Email',
                                'contentOptions' => ['style' => 'width: 10%;'],
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->email;
                                }
                            ],
                            [
                                'label' => 'Phone Number',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->phone_no;
                                }
                            ],
                            [
                                'label' => 'Safaris',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->safaris;
                                }
                            ],
                            [
                                'label' => 'Travelers',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->travelers;
                                }
                            ],
                            'staycatgory.title:raw:Stay Category',
                            [
                                'label' => 'Start Date',
                                'contentOptions' => ['style' => 'width: 5%;'],
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->start_date;
                                }
                            ],
                            [
                                'label' => 'End Date',
                                'contentOptions' => ['style' => 'width: 5%;'],
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->end_date;
                                }
                            ],
                            [
                                'label' => 'IP Address',
                                'contentOptions' => ['style' => 'width: 5%;'],
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->ip_address;
                                }
                            ],
                            [
                                'label' => 'OS/Platform',
                                'contentOptions' => ['style' => 'width: 5%;'],
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->os;
                                }
                            ],
                            [
                                'label' => 'Browser',
                                'contentOptions' => ['style' => 'width: 5%;'],
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->browser;
                                }
                            ],
                            [
                                'label' => 'Request Time',
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