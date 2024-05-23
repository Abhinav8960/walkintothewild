<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;

?>

<div class="panel panel-primary tabs-style-1">
    <?= $this->render('@backend/modules/park/views/default/_navbar', ['active_nav' => 'park_gallery']); ?>

    <div class="panel-body tabs-menu-body main-content-body-right border-top-0 border">
        <div class="tab-content">
            <div class="tab-pane fade show active" id="park_gallery">
                <div class="card-title">
                    List Of Park Gallery
                    <?= Html::button('+ Create', [
                        'class' => 'btn btn-orange popupbutton float-end',
                        'title' => 'Create',
                        'value' => '/park/park-gallery/create?' . $park_id . ''
                        // 'data-bs-toggle' => 'modal',
                        // 'data-bs-target' => '#createButton'
                    ]); ?>

                    <div class="card-body">
                        <?= $this->render('_search', ['model' => $searchModel]); ?>
                        <div id="w1-button" class="mb-3"></div>

                        <div class="table-responsive">
                            <?= GridView::widget([
                                'dataProvider' => $dataProvider,
                                'columns' => [
                                    ['class' => 'yii\grid\SerialColumn'],
                                    [
                                        'attribute' => 'image',
                                        'format' => 'html',
                                        'contentOptions' => ['style' => 'width: 10%;'],
                                        'label' => 'Image',
                                        'value' => function ($model) {
                                            return Html::img($model->Imagepath, ['alt' => 'Park Gallery Image', 'style' => 'max-width:60px;']);
                                        }
                                    ],
                                    'image_caption',
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
                                        'contentOptions' => ['style' => 'width: 15%;'],
                                        'template' => '{view}&nbsp;&nbsp;{update}&nbsp;&nbsp;{delete}',
                                        'buttons' => [
                                            'update' => function ($url, $model) {
                                                return Html::a('<img src="/img/update.png" alt="" width="25" height="25">', ['update', 'id' => $model->id], [
                                                    'class' => 'btn p-0 change-menuicon',
                                                    'title' => 'Update',
                                                ]);
                                            },
                                            'delete' => function ($url, $model) {
                                                return Html::a('<img src="/img/delete.png" alt="" width="25" height="25">', ['delete', 'id' => $model->id], [
                                                    'class' => 'btn p-0 change-menuicon',
                                                    'title' => 'Delete',
                                                    'data' => [
                                                        'confirm' => 'Are you sure you want to delete ' . $model->image . '?',
                                                        'method' => 'post',
                                                    ],
                                                ]);
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

    <!-- Modal -->
    <div class="modal fade" id="createButton" tabindex="-1" aria-labelledby="createButtonLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createButtonLabel">Create Park Gallery</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>



                    <?php ActiveForm::end(); ?>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>