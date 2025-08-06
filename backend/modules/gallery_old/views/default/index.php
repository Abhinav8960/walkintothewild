<?php

use yii\helpers\Html;

use yii\grid\GridView;
use yii\helpers\Url;

$this->title = 'Gallery List';
$this->params['title'] = $this->title;
$this->params['buttons'][] = Html::a('Pending Gallery Approval', [Url::toRoute(['/galleryapproval/default/index'])], ['class' => 'btn btn-orange me-2', 'title' => 'Gallery Approval']);

?>


<div class="card">
    <div class="card-body">
        <div id="w1-button" class="mb-3"></div>
        <?= $this->render('_search', ['model' => $searchModel]) ?>
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
                            return $model->partner ? $model->partner->business_name : '';
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
                            return $model->live_gallery_images_count;
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

                            // 'delete' => function ($url, $model) {
                            //     return Html::button(
                            //         Html::img($this->params['baseurl'] . '/img/delete.png', ['alt' => '', 'width' => 25, 'height' => 25]),
                            //         [
                            //             'value' => Url::toRoute(['delete', 'id' => $model->id]),
                            //             'class' => 'btn p-0 change-menuicon delete-popup',
                            //             'title' => 'Delete',
                            //         ]
                            //     );
                            // },

                        ]
                    ],

                ],
            ]); ?>
        </div>
    </div>
</div>


<div class="modal fade" id="deleteAction" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header popHeader">
                <h6 class="modal-title fs-5" id="exampleModalLabel">
                    Gallery Delete
                </h6>
            </div>

            <div class="modal-body modal_form">
                <div id='deleteContent'></div>
            </div>

        </div>
    </div>
</div>

<?php
$script = <<< JS

    $('.delete-popup').on('click', function () {
        $('#deleteAction').modal('show')
		.find('#deleteContent')
		.load($(this).attr('value'));
	});

JS;
$this->registerJs($script);
?>