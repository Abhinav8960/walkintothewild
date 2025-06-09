<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = 'Park Accomodation Category';
$this->params['title'] = $this->title;
?>
<div class="panel panel-primary tabs-style-2">
    <?= $this->render('@backend/modules/park/modules/safari/views/profile/_profile_navbar', ['safari_park' => $safari_model, 'park_stay_category_list' => 'active']) ?>

    <div class="panel-body tabs-menu-body main-content-body-right border">
        <div class="tab-content">
            <div class="tab-pane active">
                <div class="card">

                    <div class="card-body">
                        <button value="<?= Url::toRoute(['/park/safari/profile/add-park-stay', 'safari_park_id' => $safari_model->id]) ?>" class="btn btn-orange  mt-3 col-md-2 float-end mb-3 choose-option">+ Create</button>

                        <div class="table-responsive">
                            <?= GridView::widget([
                                'dataProvider' => $dataProvider,
                                'columns' => [
                                    ['class' => 'yii\grid\SerialColumn'],
                                    [
                                        'label' => 'Stay Category',
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return isset($model->accomodation_display) ? $model->accomodation_display->title : '';
                                        }
                                    ],

                                    [
                                        'label' => 'Status',
                                        'contentOptions' => ['style' => 'width: 10%;'],
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return $model->newstatuslabel;
                                        }
                                    ],

                                    [
                                        'class' => 'yii\grid\ActionColumn',
                                        'header' => "Actions",
                                        'contentOptions' => ['style' => 'width: 20%;'],
                                        'template' => '{remove}',
                                        'buttons' => [
                                            'remove' => function ($url, $model) {
                                                return  Html::a('Remove', ['remove-accomodation-category', 'safari_park_id' => $model->safari_park_id, 'id' => $model->id], [
                                                    'class' => 'btn btn-info',
                                                    'title' => 'Remove',

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
</div>

<div class="modal fade" id="modalAction" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header flageHeader">
                <h6 class="modal-title fs-5" id="exampleModalLabel">
                    Add Accomodation
                </h6>
            </div>

            <div class="modal-body modal_form">
                <div id='modalContent'></div>
            </div>

        </div>
    </div>
</div>

<?php
$script = <<< JS
        $('.choose-option').on('click', function () {
            $('#modalAction').modal('show')
            .find('#modalContent')
            .load($(this).attr('value'));
        });
JS;
$this->registerJs($script);
?>