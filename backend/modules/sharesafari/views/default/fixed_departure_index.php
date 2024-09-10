<?php


/* @var $this yii\web\View */
/* @var $model common\models\corporate\Corporate */

use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Fixed Departure';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;

$this->params['baseurl'] = $this->assetManager->getBundle('\backend\assets\NovaAppAsset')->baseUrl;
if (Yii::$app->user->identity) {
    if (Yii::$app->user->identity->is_safari_operator == 1) {
        // $this->params['buttons'][] = Html::Button('+ Organize New Safari', ['value' => "/sharesafari/default/organize-safari-new", 'class' => 'btn popupButton btn-orange', 'title' => 'Organize New Safari']);
    }
}

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
                        'label' => 'Park',
                        'contentOptions' => ['style' => 'width: 15%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->park->title) ? Html::a($model->park->title, ['fixed-view', 'id' => $model->id], [
                                'style' => 'color: black !important;',
                                'title' => 'View',
                            ]) : '';
                        }
                        // 'value' => function ($model) {
                        //     return isset($model->park) ? $model->park->title : "";
                        // }
                    ],
                    [
                        'label' => 'Start Date',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return date('Y-m-d', strtotime($model->start_date));
                        }
                    ],
                    [
                        'label' => 'End Date',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return date('Y-m-d', strtotime($model->end_date));
                        }
                    ],
                    [
                        'label' => 'Cut Off Date',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return date('Y-m-d', strtotime($model->cut_off_date));
                        }
                    ],
                    [
                        'label' => 'Number Of Safari',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->no_of_safari;
                        }
                    ],
                    [
                        'label' => 'Number Of Seat',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->total_seat;
                        }
                    ],
                    [
                        'label' => 'Organized By',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->user->name) ? $model->user->name : '';
                        }
                    ],
                    [
                        'label' => 'Status',
                        'contentOptions' => ['style' => 'width: 10%; text-align: center;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->statuslabel;
                        }
                    ],
                    // [
                    //     'class' => 'yii\grid\ActionColumn',
                    //     'header' => "Actions",
                    //     'contentOptions' => ['style' => 'width: 10%; text-align: center;'],
                    //     'template' => '',
                    //     // 'template' => '{view}',
                    //     'buttons' => [
                    //         // 'view' => function ($url, $model) {
                    //         //     return  Html::a('<img src="' . $this->params['baseurl'] . '/img/view.png" alt="" width="25" height="25">
                    //         // ', ['view', 'id' => $model->id], [
                    //         //         'class' => 'btn p-0 change-menuicon',
                    //         //         'title' => 'view',

                    //         //     ]);
                    //         // },

                    //     ]
                    // ],
                ],
            ]); ?>
        </div>
    </div>
</div>

<div class="modal fade" id="modalUpdate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header flageHeader">
                <h6 class="modal-title fs-5" id="exampleModalLabel">
                    Organize New Safari
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


    
function writeareviewfunction() {
     $('.popup').on('click', function () {
        $('#modalUpdate').modal('show')
		.find('#modalContent')
		.load($(this).attr('value'));
	});
}
writeareviewfunction();
    
          
             
JS;
$this->registerJs($script);
?>