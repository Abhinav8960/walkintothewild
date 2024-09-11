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
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
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
                        'label' => 'Interested',
                        'contentOptions' => ['style' => 'width: 10%; text-align: center;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->intrested) ? $model->getIntrested()->where(['status' => 1])->count() : '';
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