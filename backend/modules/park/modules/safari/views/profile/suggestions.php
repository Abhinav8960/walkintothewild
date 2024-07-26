<?php

/* @var $this yii\web\View */
/* @var $model apps\models\employee\Employee */

use common\models\GeneralModel;
use yii\helpers\Html;

use yii\grid\GridView;

$this->title = 'Safari Park Suggestions';
$this->params['breadcrumbs_home_url'] = '#';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
?>
<div class="panel panel-primary tabs-style-2">
    <?= $this->render('@backend/modules/park/modules/safari/views/profile/_profile_navbar', ['safari_park' => $safari_model, 'suggestions_active' => 'active']) ?>

    <div class="panel-body tabs-menu-body main-content-body-right border">
        <div class="tab-content">
            <div class="tab-pane active">
                <div class="card">

                    <div class="card-body">
                        <div class="table-responsive">
                            <?= GridView::widget([
                                'dataProvider' => $dataProvider,
                                'columns' => [
                                    ['class' => 'yii\grid\SerialColumn'],
                                    [
                                        'label' => 'Category',
                                        'contentOptions' => ['style' => 'width: 10%;'],
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return isset($model->master_suggestion_id) ? GeneralModel::suggestioncategory()[$model->master_suggestion_id] : '';
                                        }
                                    ],

                                    [
                                        'label' => 'Who Suggested',
                                        'contentOptions' => ['style' => 'width: 10%;'],
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return isset($model->you_are_id) ? GeneralModel::operatorcategory()[$model->you_are_id] : '';
                                        }
                                    ],
                                    'details',
                                    'created_at:dateTime:Created at',
                                    [
                                        'label' => 'Status',
                                        'contentOptions' => ['style' => 'width: 5%;'],
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return $model->statuslabel;
                                        }
                                    ],
                                    [
                                        'class' => 'yii\grid\ActionColumn',
                                        'header' => "Actions",
                                        'contentOptions' => ['style' => 'width: 20%;'],
                                        'template' => '{approve}',
                                        'buttons' => [
                                            'approve' => function ($url, $model) {
                                                if ($model->is_approved == 0) {
                                                    return  Html::a('Approve', ['approve', 'id' => $model->id], [
                                                        'class' => 'btn btn-success',
                                                        'title' => 'approve',
                                                        'data' => [
                                                            'confirm' => 'Are you sure you want to approve  this suggestion?',
                                                            'method' => 'post',
                                                        ],
                                                    ]);
                                                } else {
                                                    return  Html::a('Disapprove', ['disapprove', 'id' => $model->id], [
                                                        'class' => 'btn btn-danger',
                                                        'title' => 'Disapprove',
                                                        'data' => [
                                                            'confirm' => 'Are you sure you want to disapprove this suggestion?',
                                                            'method' => 'post',
                                                        ],
                                                    ]);
                                                }
                                            },
                                        ]
                                    ],
                                ],
                            ]); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>