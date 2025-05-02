<?php

use yii\helpers\Html;

use yii\widgets\Pjax;
use yii\grid\GridView;

$this->title = 'Posts';
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
                        'label' => 'File',
                        'contentOptions' => ['style' => 'width: 10%; text-align: center;'],
                        'headerOptions' => ['style' => 'width: 10%; text-align: center;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            if ($model->filepath) {
                                return Html::tag('div', Html::img(Yii::$app->params['cloud_front_url'] . $model->filepath, [
                                    'alt' => 'Uploaded Image',
                                    'height' => '240px',
                                    'width' => '320px'
                                ]), ['style' => 'text-align: center;']);
                            }
                            return '';
                        }
                    ],
                    [
                        'label' => 'Caption',
                        'contentOptions' => ['style' => 'width: 10%; text-align: center;'],
                        'headerOptions' => ['style' => 'width: 10%; text-align: center;'],

                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->caption;
                        }
                    ],
                    [
                        'label' => 'Date',
                        'contentOptions' => ['style' => 'width: 10%; text-align: center;'],
                        'headerOptions' => ['style' => 'width: 10%; text-align: center;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return date('Y-m-d H:i:s', $model->created_at);
                        }
                    ],
                    [
                        'label' => 'Last Updated Time',
                        'contentOptions' => ['style' => 'width: 10%; text-align: center;'],
                        'headerOptions' => ['style' => 'width: 10%; text-align: center;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return date('Y-m-d H:i:s', $model->updated_at);
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