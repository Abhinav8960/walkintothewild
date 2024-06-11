<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\grid\GridView;


$this->title = 'Safari Operator Tour Registrations';
$this->params['breadcrumbs_home_url'] = '/registration/safari-operator-tour';
$this->params['breadcrumbs'][] =  ['label' => 'Registration', 'url' => '#'];
$this->params['breadcrumbs'][] = $this->title;
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
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'label' => 'Business Name',
                        'contentOptions' => ['style' => 'width: 15%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->business_name;
                        }
                    ],
                    [
                        'label' => 'Registered Name',
                        'contentOptions' => ['style' => 'width: 15%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->register_comapany_name;
                        }
                    ],
                    [
                        'label' => 'Phone Number',
                        'contentOptions' => ['style' => 'width: 15%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->phone_no;
                        }
                    ],
                    [
                        'label' => 'Category',
                        'contentOptions' => ['style' => 'width: 20%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            if ($model->category_id) {
                                return isset(GeneralModel::operatorcategory()[$model->category_id]) ? GeneralModel::operatorcategory()[$model->category_id] : '';
                            }
                        }
                    ],
                    [
                        'label' => 'Budget Segment',
                        'contentOptions' => ['style' => 'width: 15%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            $budget = [];
                            if ($model->is_offer_premium_budget == 1) {
                                $budget[] = "Premium";
                            }
                            if ($model->is_offer_standard_budget == 1) {
                                $budget[] = "Standard";
                            }
                            if ($model->is_offer_economical_budget == 1) {
                                $budget[] = "Economical";
                            }
                            return implode(', ', $budget);
                        }
                    ],
                    [
                        'label' => 'Status',
                        'contentOptions' => ['style' => 'width: 5%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            if ($model->is_approved) {
                                return isset(GeneralModel::yesnooption()[$model->is_approved]) ? GeneralModel::yesnooption()[$model->is_approved] : '';
                            } else {
                                return 'No';
                            }
                        }
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => "Actions",
                        'contentOptions' => ['style' => 'width: 15%;'],
                        'template' => '{view}&nbsp;&nbsp;{delete}&nbsp;&nbsp;{suspend}',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return  Html::a('<img src="/img/view.png" alt="" width="25" height="25">
                                ', ['view', 'id' => $model->id], [
                                    'class' => 'btn p-0 change-menuicon',
                                    'title' => 'View',

                                ]);
                            },
                            'delete' => function ($url, $model) {
                                if ($model->status == 2) {
                                    return  Html::a('<img src="/img/delete.png" alt="" width="25" height="25">', ['delete', 'id' => $model->id], [
                                        'class' => 'btn p-0 change-menuicon',
                                        'title' => 'Delete',
                                        'data' => [
                                            'confirm' => 'Are you sure you want to delete  ' . $model->business_name . '?',
                                            'method' => 'post',
                                        ],
                                    ]);
                                }
                            },
                            'suspend' => function ($url, $model) {
                                return \backend\widgets\SuspendActiveButton::widget(['model' => $model, 'active_title' => 'Safari Tour Operator', 'suspend_title' => 'Safari Tour Operator']);
                            },

                        ]
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>