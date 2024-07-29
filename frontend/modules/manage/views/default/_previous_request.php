<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\GeneralModel;

?>
<div class="card card account-settingside">
    <div class="card-body p-4">
        <h6 class="fs-6 fw-bold mb-4" id="w1-button">Previous Request</h6>
        <div class="table-responsive table_design_manage">
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
                                    'class' => 'btn btn-info bg-blues py-2',
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