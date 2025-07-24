<?php

use common\models\GeneralModel;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Safari Tour Operator : ' . $operator_model->business_name;
$this->params['title'] = $this->title;

?>
<div class="panel panel-primary tabs-style-2">
    <?= $this->render('@support/modules/operator/views/safari-operator/_navbar.php', ['model' => $operator_model, 'active_navbar' => 'operator_park']) ?>


    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        <div class="table-wrapper">
            <div class="table-responsive">
                <div class="min-width-table">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => "{items}\n<div class='row align-items-center mt-3'>
                            <div class='col-md-4'></div>
                        </div>",
                        'tableOptions' => ['class' => 'table tablecustoms table-striped align-middle w-100'],
                        'columns' => [
                            [
                                'class' => 'yii\grid\SerialColumn',
                                'headerOptions' => ['style' => 'width: 1%;'],
                            ],
                            [
                                'label' => 'Park',
                                // 'headerOptions' => ['style' => 'width:15%;'],
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return isset($model->park) ? $model->park->title : '';
                                }
                            ],
                            [
                                'label' => 'Status',
                                'headerOptions' => ['style' => 'width:15%;'],
                                // 'contentOptions' => ['style' => 'width: 10%;'],
                                'format' => 'raw',
                                'value' => function ($model) {
                                    return $model->newstatuslabel;
                                }
                            ],
                            [
                                'header' => 'Action',
                                'value' => function ($model) use ($operator_model) {
                                    return Html::a(
                                        'Remove',
                                        ['remove-park', 'id' => $operator_model->id, 'park_id' => $model->id],
                                        [
                                            'class' => 'btn btn-xs btn-danger',
                                            'data-method' => 'post',
                                            'data-confirm' => 'Are you sure you want to remove this park?',
                                            'title' => 'Remove Park',
                                        ]
                                    );
                                },
                                'format' => 'raw',
                                'headerOptions' => ['style' => 'width:15%;'],
                                'contentOptions' => ['style' => 'width:15%;'],
                            ],
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="addAction" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header popHeader">
                <h6 class="modal-title fs-5" id="exampleModalLabel">
                    Add Park
                </h6>
            </div>

            <div class="modal-body modal_form">
                <div id='addContent'></div>
            </div>

        </div>
    </div>
</div>

<?php
$script = <<< JS

    $('.add-popup').on('click', function () {
        $('#addAction').modal('show')
		.find('#addContent')
		.load($(this).attr('value'));
	});


JS;
$this->registerJs($script);
?>


<!-- <div class="tab-pane fade" id="ninetcont" role="tabpanel" aria-labelledby="contact-tab">
    <div class="table-wrapper shadow-none rounded-0 pb-4">
        <div class="table-responsive">
            <div class="min-width-table">
                <div id="w0" class="grid-view">
                    <table class="table tablecustoms table-striped align-middle w-100">
                        <thead>
                            <tr>
                                <th style="width: 1%;">#</th>
                                <th>Park</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr data-key="838">
                                <td>1</td>
                                <td>Lorem ipsum is a dummy</td>
                                <td>
                                    <div class="active-btn">
                                        <a href="">ACTIVE</a>
                                    </div>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div> -->