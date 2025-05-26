<?php

use common\models\GeneralModel;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Leads';
$this->params['title'] = $this->title;
?>


<div class="card">
    <div class="card-body">
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        <div id="w1-button" class="mb-3"></div>

        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'headerOptions' => ['style' => 'width: 5%;'],
                    ],
                    [
                        'label' => 'User Name',
                        'headerOptions' => ['style' => 'width: 15%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            $imageUrl = isset($model->user) ? $model->user->profileImage : $this->params['baseurl'] . '/img/NewBanner_big.png';
                            $name = isset($model->user) ? $model->user->name : '';
                            return '<img src="' . $imageUrl . '" alt="" style="max-height:30px;"> ' . Html::encode($name);
                        },
                    ],
                    [
                        'label' => 'Source',
                        'headerOptions' => ['style' => 'width: 15%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->sourceLabel;
                        }
                    ],

                    [
                        'label' => 'Safaris',
                        'contentOptions' => ['style' => 'text-align: left;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return !empty($model->safaris) ? $model->safaris : '';
                        }
                    ],
                    [
                        'label' => 'Travelers',
                        'contentOptions' => ['style' => 'text-align: left;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return !empty($model->travelers) ? $model->travelers : '';
                        }
                    ],

                    [
                        'label' => 'Accomodation',
                        'contentOptions' => ['style' => 'text-align: left;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return !empty($model->staycatgory) ? $model->staycatgory->title : '';
                        }
                    ],
                    [
                        'label' => 'Travel Date looking',
                        'headerOptions' => ['style' => 'width: 15%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            $str =  date('d M, Y', strtotime($model->from_date));
                            if (!empty($model->to_date)) {
                                $str .=  '- ' . date('d M, Y', strtotime($model->to_date));
                            }
                            return $str;
                        }
                    ],
                    [
                        'label' => 'Lead Received Date',
                        'headerOptions' => ['style' => 'width: 15%;'],
                        'contentOptions' => ['style' => 'text-align: left;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return date('d M, Y h:i A', $model->created_at);
                        }
                    ],

                    [
                        'label' => 'Quotation Count',
                        'headerOptions' => ['style' => 'width: 15%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->quotation ? count($model->quotation) : '';
                        }
                    ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => "Actions",
                        'contentOptions' => ['style' => 'width: 10%; text-align: left;'],
                        'template' => '{view}',
                        'buttons' => [

                            'view' => function ($url, $model) {
                                return  Html::a('<img src="' . $this->params['baseurl'] . '/img/view.png" alt="" width="25" height="25">
                                ', ['/leads/default/view', 'id' => $model->id], [
                                    'class' => 'btn p-0 change-menuicon',
                                    'title' => 'View',
                                ]);
                            },


                        ]
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>