<?php


/* @var $this yii\web\View */
/* @var $model common\models\corporate\Corporate */

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Fixed Departure';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;

$this->params['baseurl'] = $this->assetManager->getBundle('\support\assets\NovaAppAsset')->baseUrl;
if (Yii::$app->user->identity) {
    if (Yii::$app->user->identity->is_safari_operator == 1) {
        // $this->params['buttons'][] = Html::Button('+ Organize New Safari', ['value' => "/sharesafari/default/organize-safari-new", 'class' => 'btn popupButton btn-orange', 'title' => 'Organize New Safari']);
    }
}

?>
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>

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
                        'headerOptions' => ['style' => 'width: 1%;'],
                    ],
                    [
                        'label' => 'Title',
                        'format' => 'raw',
                        'value' => function ($model) {
                        
                            return $model->share_safari_title <> '' ? $model->share_safari_title : 'Untitled';
                        }

                    ],
                    [
                        'label' => 'Start Date',
                        'headerOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->start_date) ? date('Y-m-d', strtotime($model->start_date)) : '';
                        }
                    ],
                    [
                        'label' => 'End Date',
                        'headerOptions' => ['style' => 'width: 10%;'],

                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->end_date) ? date('Y-m-d', strtotime($model->end_date)) : '';
                        }
                    ],
                    [
                        'label' => 'Cut Off Date',
                        'headerOptions' => ['style' => 'width: 10%;'],

                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->cut_off_date) ? date('Y-m-d', strtotime($model->cut_off_date)) : '';
                        }
                    ],
                    [
                        'label' => 'Safaris',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->no_of_safari;
                        }
                    ],
                    [
                        'label' => 'Seats',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->total_seat;
                        }
                    ],
                    [
                        'label' => 'Organizer',

                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->user->name) ? $model->user->name : '';
                        }
                    ],
                    [
                        'label' => 'Joined',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->intrested) ? Html::button($model->getIntrested()->where(['status' => 1])->count(), [
                                'value' => Url::toRoute(['intrested', 'id' => $model->id]),
                                'style' => 'color: black !important;',
                                'class' => 'intrested btn-danger',
                                'title' => 'Intrested',
                            ]) : '';
                        }
                    ],

                    [
                        'label' => 'Leaved',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->intrested) ? Html::button($model->getIntrested()->where(['status' => 0])->count(), [
                                'value' => Url::toRoute(['leaved', 'id' => $model->id]),
                                'style' => 'color: black !important;',
                                'class' => 'leaved btn-info',
                                'title' => 'Leaved',
                            ]) : '';
                        }
                    ],
                    [
                        'label' => 'Is Publish on Web/App',
                        'headerOptions' => ['style' => 'width: 20%;'],

                        'format' => 'raw',
                        'value' => function ($model) {
                            $str = $model->is_published_on_web == 1 ? '<a href="/sharesafari/default/publish-on-web?id=' . $model->id . '" class="badge badge-success">Yes</a>' : '<a class="badge badge-danger">No</a>';
                            $str .= '/';
                            $str .= $model->is_published_on_api == 1 ? '<a href="/sharesafari/default/publish-on-api?id=' . $model->id . '" class="badge badge-success">Yes</a>' : '<a class="badge badge-danger">No</a>';
                            return $str;
                        }
                    ],
                    [
                        'label' => 'Status',
                        'contentOptions' => ['style' => 'width: 10%; text-align: left;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->statuslabel;
                        }
                    ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => "Actions",
                        'contentOptions' => ['style' => 'width: 10%; text-align: left;'],
                        'template' => '{view}',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return Html::a('<i class="mdi mdi-eye"></i>',
                                    [
                                        Url::toRoute(['fixed-view', 'id' => $model->id])
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

<div class="modal fade" id="intrested" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header flageHeader">
                <h6 class="modal-title fs-5" id="exampleModalLabel">
                    Intrested
                </h6>
            </div>

            <div class="modal-body modal_form">
                <div id='intrestedContent'></div>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="leaved" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header flageHeader">
                <h6 class="modal-title fs-5" id="exampleModalLabel">
                    Leaved
                </h6>
            </div>

            <div class="modal-body modal_form">
                <div id='leavedContent'></div>
            </div>

        </div>
    </div>
</div>

<?php
$script = <<< JS


    
function intrested() {
     $('.intrested').on('click', function () {
        $('#intrested').modal('show')
		.find('#intrestedContent')
		.load($(this).attr('value'));
	});
}
intrested();

function leaved() {
     $('.leaved').on('click', function () {
        $('#leaved').modal('show')
		.find('#leavedContent')
		.load($(this).attr('value'));
	});
}
leaved();
    
          
             
JS;
$this->registerJs($script);
?>