<?php

use yii\helpers\Html;

use yii\grid\GridView;
use yii\helpers\Url;

$this->title = 'Collection ' . '(' . $model->title . ')';
$this->params['title'] = $this->title;
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

                    // [
                    //     'class' => 'yii\grid\ActionColumn',
                    //     'header' => "Actions",
                    //     'headerOptions' => ['style' => 'width:10%; text-align:left;'],
                    //     'template' => '{view}',
                    //     'buttons' => [
                    //         'view' => function ($url, $model) {

                    //             return Html::a(
                    //                 Html::img($this->params['baseurl'] . '/img/view.png', ['alt' => '', 'width' => 25, 'height' => 25]),
                    //                 [
                    //                     Url::toRoute(['view', 'id' => $model->id])
                    //                 ],
                    //                 [
                    //                     'class' => 'btn p-0 change-menuicon',
                    //                     'title' => 'View',
                    //                 ]
                    //             );
                    //         },

                    //     ]
                    // ],

                ],
            ]); ?>
        </div>
    </div>
</div>