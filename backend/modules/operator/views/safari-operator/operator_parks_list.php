<?php

use common\models\GeneralModel;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Safari Tour Operator : ' . $operator_model->business_name;
$this->params['title'] = $this->title;

?>
<div class="panel panel-primary tabs-style-2">
    <?= $this->render('@backend/modules/operator/views/safari-operator/_navbar.php', ['model' => $operator_model, 'active_navbar' => 'operator-parks']) ?>
    <div class="panel-body tabs-menu-body main-content-body-right border">
        <div class="tab-content">
            <div class="tab-pane active">
                <?= Html::button(
                    'Add Park',
                    [
                        'value' => Url::toRoute(['add-park', 'id' => $operator_model->id]),
                        'class' => 'btn btn-orange mb-2 add-popup',
                        'title' => 'Add',
                    ]
                ); ?>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <?= GridView::widget([
                                'dataProvider' => $dataProvider,
                                'columns' => [
                                    [
                                        'class' => 'yii\grid\SerialColumn',
                                        'headerOptions' => ['style' => 'width:5%;'],
                                        'contentOptions' => ['style' => 'width:5%;'],
                                    ],
                                    [
                                        'label' => 'Park',
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return isset($model->park) ? $model->park->title : '';
                                        }
                                    ],
                                    [
                                        'label' => 'Status',
                                        'headerOptions' => ['style' => 'width:10%;'],
                                        'contentOptions' => ['style' => 'width: 10%;'],
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