<?php

use yii\helpers\Html;

use yii\widgets\Pjax;
use yii\grid\GridView;

$this->title = 'Sightings';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
// $this->params['buttons'][] = Html::a('Create',  ['create'], ['class' => 'btn btn-orange', 'title' => 'Create']);
?>
<?php Pjax::begin([
    'id' => 'grid-data',
    'enablePushState' => false,
    'enableReplaceState' => false,
    'timeout' => false,
]); ?>

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
                        'label' => 'Sighting Details',
                        'contentOptions' => ['style' => 'width: 10%; text-align: center;'],
                        'headerOptions' => ['style' => 'width: 10%; text-align: center;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->description;
                        }
                    ],
                    [
                        'label' => 'Location',
                        'contentOptions' => ['style' => 'width: 10%; text-align: center;'],
                        'headerOptions' => ['style' => 'width: 10%; text-align: center;'],

                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->locationDetail->title;
                        }
                    ],
                    [
                        'label' => 'Animal',
                        'contentOptions' => ['style' => 'width: 10%; text-align: center;'],
                        'headerOptions' => ['style' => 'width: 10%; text-align: center;'],

                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->animalDetail->name;
                        }
                    ],
                    [
                        'label' => 'Safari Session',
                        'contentOptions' => ['style' => 'width: 10%; text-align: center;'],
                        'headerOptions' => ['style' => 'width: 10%; text-align: center;'],

                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->safariSessionDetail->title;
                        }
                    ],
                    [
                        'label' => 'Date',
                        'contentOptions' => ['style' => 'width: 10%; text-align: center;'],
                        'headerOptions' => ['style' => 'width: 10%; text-align: center;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->post_datetime;
                        }
                    ],
                    [
                        'label' => 'Last Updated Time',
                        'contentOptions' => ['style' => 'width: 10%; text-align: center;'],
                        'headerOptions' => ['style' => 'width: 10%; text-align: center;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return date('Y-m-d H:i:s',$model->updated_at);
                        }
                    ],

                    [
                        'label' => 'Status',
                        'contentOptions' => ['style' => 'width: 10%; text-align: center;'],
                        'headerOptions' => ['style' => 'width: 10%; text-align: center;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->newstatuslabel;
                        }
                    ],

                ],
            ]); ?>
        </div>
    </div>
</div>

<?php Pjax::end(); ?>