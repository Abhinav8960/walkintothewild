<?php

use yii\helpers\Html;

use yii\grid\GridView;
use yii\helpers\Url;

$this->title = 'Collection ' . '(' . $model->title . ')';
$this->params['title'] = $this->title;
$this->params['buttons'][] = Html::a('+ Set Sequence', [Url::toRoute(['set-sequence', 'partner_gallery_id' => $model->id])], ['class' => 'btn btn-info me-2', 'title' => 'Set Sequence']);
$this->params['buttons'][] = Html::a('+ Upload Gallery', [Url::toRoute(['create-gallery', 'partner_gallery_id' => $model->id])], ['class' => 'btn btn-orange float-end', 'title' => 'Upload Gallery']);
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
                        'label' => 'Title',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->title) ? $model->title : '';
                        }
                    ],
                    [
                        'label' => 'Caption',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->caption) ? $model->caption : '';
                        }
                    ],

                    [
                        'label' => 'Gallery',
                        'format' => 'raw',
                        'headerOptions' => ['style' => 'text-align: center;'],
                        'value' => function ($model) {
                            return Html::tag('div', Html::img($model->gallery_image, [
                                'alt' => 'Uploaded Image',
                                'style' => 'width:20%; height: 20%;',
                            ]), ['style' => 'text-align: center;']);
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
                        'template' => '{check}&nbsp{edit}&nbsp{set}',
                        'buttons' => [
                            'check' => function ($url, $model) {
                                if ($model->status == 1) {
                                    return Html::a('<i class="fa fa-toggle-on"></i>', ['swtich', 'id' => $model->id], [
                                        'class' => 'btn btn-xs btn-success',
                                        'data-method' => 'post',
                                        'data-confirm' => 'Are you sure to Inactive this Gallery?',
                                        'title' => 'Remove ',
                                        'data-bs-toggle' => "tooltip"
                                    ]);
                                } else {
                                    return Html::a('<i class="fa fa-toggle-off"></i>', ['swtich', 'id' => $model->id], [
                                        'class' => 'btn btn-xs btn-warning',
                                        'data-method' => 'post',
                                        'data-confirm' => 'Are you sure to Active this Gallery?',
                                        'title' => 'Show in Front',
                                        'data-bs-toggle' => "tooltip"
                                    ]);
                                }
                            },
                            'edit' => function ($url, $model) {
                                return Html::a(
                                    Html::img($this->params['baseurl'] . '/img/update.png', ['alt' => '', 'width' => 25, 'height' => 25]),
                                    [
                                        Url::toRoute(['update-gallery-image', 'id' => $model->id])
                                    ],
                                    [
                                        'class' => 'btn p-0 change-menuicon',
                                        'title' => 'Edit',
                                    ]
                                );
                            },

                            'set' => function ($url, $model) {
                                return Html::a(
                                    'Set Thumbnail',
                                    ['update-thumbnail', 'partner_gallery_id' => $model->partner_gallery_id, 'id' => $model->id],
                                    [
                                        'class' => 'btn btn-sm btn-warning',
                                        'title' => 'Set Thumbnail',
                                        'data-confirm' => 'Are you sure you want to set this as the thumbnail?',
                                        'data-method' => 'post',
                                    ]
                                );
                            }

                        ]
                    ],

                ],
            ]); ?>
        </div>
    </div>
</div>