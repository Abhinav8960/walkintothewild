<?php

use yii\helpers\Html;

use yii\widgets\Pjax;
use yii\grid\GridView;

$this->title = 'Park Review';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
?>
<?php Pjax::begin([
    'id' => 'grid-data',
    'enablePushState' => false,
    'enableReplaceState' => false,
    'timeout' => false,
]); ?>

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
                        'label' => 'Park Name',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->park->title) ? $model->park->title : '';
                        }
                    ],
                    [
                        'label' => 'Name',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->user->name) ? $model->user->name : '';
                        }
                    ],
                    [
                        'label' => 'Review',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->review) ? $model->review : '';
                        }
                    ],
                    [
                        'label' => 'Rating',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->rating;
                        }
                    ],
                    [
                        'label' => 'Status',
                        'contentOptions' => ['style' => 'width: 7%; text-align: center;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->statuslabel;
                        }
                    ],
                    [
                        'header' => 'Action',
                        'value' => function ($model) {
                            if ($model->status == 2) {
                                return Html::a('<i class="fa fa-toggle-on"></i>', ['approved', 'id' => $model->id], [
                                    'class' => 'btn btn-xs btn-success',
                                    'data-method' => 'post',
                                    'data-confirm' => 'Are you sure to approved this review?',
                                    'title' => 'Approved Review', 'data-bs-toggle' => "tooltip"
                                ]);
                            } else {
                                return Html::a('<i class="fa fa-toggle-off"></i>', ['approved', 'id' => $model->id], [
                                    'class' => 'btn btn-xs btn-danger',
                                    'data-method' => 'post',
                                    'data-confirm' => 'Are you sure to disapproved this review?',
                                    'title' => 'Block User', 'data-bs-toggle' => "tooltip"
                                ]);
                            }
                        },
                        'format' => 'raw',
                        'headerOptions' => ['style' => 'width:5%;'],
                        'contentOptions' => ['style' => 'width: 5%; text-align: center;'],
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>

<?php Pjax::end(); ?>