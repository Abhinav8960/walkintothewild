<?php


/* @var $this yii\web\View */
/* @var $model common\models\corporate\Corporate */

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Share Safari';
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
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
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
                        'contentOptions' => ['style' => 'width: 15%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->share_safari_title) ? Html::a($model->share_safari_title, ['view', 'id' => $model->id], [
                                'style' => 'color: black !important;',
                                'title' => 'View',
                            ]) : '';
                        }
                    ],
                    [
                        'label' => 'Start Date',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->start_date) ? date('Y-m-d', strtotime($model->start_date)) : '';
                        }
                    ],
                    [
                        'label' => 'End Date',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->end_date) ? date('Y-m-d', strtotime($model->end_date)) : '';
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
                            return $model->share_seat;
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
                        'label' => 'Joined',
                        'contentOptions' => ['style' => 'width: 10%; text-align: center;'],
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
                        'contentOptions' => ['style' => 'width: 10%; text-align: center;'],
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
                        'label' => 'Status',
                        'contentOptions' => ['style' => 'width: 10%; text-align: center;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->statuslabel;
                        }
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