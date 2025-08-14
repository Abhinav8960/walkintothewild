<?php

use yii\helpers\Html;

use yii\grid\GridView;
use yii\helpers\Url;

$this->title = 'Gallery For Approval';
$this->params['title'] = $this->title;

?>


<div class="card">
    <div class="card-body">
        <div id="w1-button" class="mb-3"></div>

        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'contentOptions' => ['style' => 'width: 5%;'],
                    ],

                    [
                        'label' => 'Partner',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->partner->business_name ?? '';
                        }
                    ],
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
                    // [
                    //     'label' => 'Status',
                    //     'contentOptions' => ['style' => 'width: 15%; text-align: left;'],
                    //     'format' => 'raw',
                    //     'value' => function ($model) {
                    //         return $model->newstatuslabel;
                    //     }
                    // ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => "Actions",
                        'headerOptions' => ['style' => 'width:10%; text-align:left;'],
                        'template' => '{view}',
                        'buttons' => [
                            'view' => function ($url, $model) {

                                return Html::a(
                                    Html::img($this->params['baseurl'] . '/img/view.png', ['alt' => '', 'width' => 25, 'height' => 25]),
                                    [
                                        Url::toRoute(['view', 'id' => $model->id])
                                    ],
                                    [
                                        'class' => 'btn p-0 change-menuicon',
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