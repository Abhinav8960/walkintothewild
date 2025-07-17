<?php

use yii\helpers\Html;

use yii\grid\GridView;
use yii\helpers\Url;

$this->title = 'Gallery';
// $this->params['title'] = $this->title;
$this->params['buttons'][] = Html::a('+ Create', ['create'], ['class' => 'button-created create float-end', 'title' => 'Create']);
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
                        'contentOptions' => ['style' => 'width: 5%;'],
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
                        'label' => 'Park Name',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->park_label) ? $model->park_label->title : '';
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