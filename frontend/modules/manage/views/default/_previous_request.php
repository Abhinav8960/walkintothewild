<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\GeneralModel;

?>
<div class="card">
    <div class="card-body">
        <div id="w1-button" class="mb-3" style="font-weight: bolder;">Previous Request</div>
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
                        'label' => 'Approved Status',
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
                        'contentOptions' => ['style' => 'width: 5%;'],
                        'template' => '{view}&nbsp',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return  Html::a('View
                                ', ['viewrequest', 'id' => $model->id], [
                                    'class' => 'btn btn-info',
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