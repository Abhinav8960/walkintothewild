<?php

use yii\helpers\Html;

use yii\grid\GridView;
use yii\helpers\Url;

$this->title = 'Gallery For Approval';
$this->params['title'] = $this->title;

?>


<div class="table-wrapper">
    <div class="table-responsive">

        <div class="min-width-table">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'layout' => "{items}\n<div class='row align-items-center mt-3'>
                            <div class='col-md-4 text-start mb-2'>{summary}</div>
                            <div class='col-md-4 text-center mb-2'>{pager}</div>
                            <div class='col-md-4'></div>
                        </div>",
                'tableOptions' => ['class' => 'table tablecustoms table-striped align-middle w-100'],
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'headerOptions' => ['style' => 'width: 1%;'],
                    ],

                    // [
                    //     'label' => 'Partner',
                    //     'format' => 'raw',
                    //     'value' => function ($model) {
                    //         return $model->partner->business_name ?? '';
                    //     }
                    // ],
                    [
                        'label' => 'Gallery Name',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->title;
                        }
                    ],
                    [
                        'label' => 'Thumbnail',
                        'format' => 'raw',
                        'value' => function ($model) {
                            if ($model->thumbnail != null) {
                                return '<img src="' . $model->thumbnail . '" alt="ALT IMG" style="max-width: 100px;">';
                            }
                            return '';
                        }
                    ],
                    [
                        'label' => 'Number of Images',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->gallery_count;
                        }
                    ],
                    [
                        'label' => 'Status',
                        'contentOptions' => ['style' => 'width: 15%; text-align: left;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->newstatuslabel;
                        }
                    ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => "Actions",
                        'headerOptions' => ['style' => 'width:10%; text-align:left;'],
                        'template' => '{view}',
                        'buttons' => [
                            'view' => function ($url, $model) {

                                return Html::a('<i class="mdi mdi-eye"></i>',
                                    [
                                        Url::toRoute(['view', 'id' => $model->id])
                                    ],
                                    [
                                        'class' => 'action-icon',
                                        'title' => 'View',
                                    ]
                                );
                            },

                        ]
                    ],

                ],
            ]); ?>
        </div>
    </div>
</div>