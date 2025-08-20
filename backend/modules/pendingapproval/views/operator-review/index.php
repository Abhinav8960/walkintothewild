<?php

use yii\helpers\Html;

use yii\widgets\Pjax;
use yii\grid\GridView;

$this->title = 'Operator Review';
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
                        'label' => 'Partner Name',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->operator->business_name) ? $model->operator->business_name : '';
                        }
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
                        'label' => 'Rating',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            $stars = '';
                            $rating = (int)$model->rating;
                            for ($i = 1; $i <= 5; $i++) {
                                $stars .= $i <= $rating
                                    ? '<span style="color: #FFD700;">&#9733;</span>'
                                    : '<span style="color: #ccc;">&#9734;</span>';
                            }
                            return $stars;
                        }
                    ],
                    [
                        'header' => 'Action',
                        'format' => 'raw',
                        'headerOptions' => ['style' => 'width:5%;'],
                        'contentOptions' => ['style' => 'width: 5%; text-align: center;'],
                        'value' => function ($model) {
                            if ($model->status == 10) {
                                return Html::a('Approved', ['approved', 'id' => $model->id], [
                                    'class' => 'btn btn-xs btn-success',
                                    'data-method' => 'post',
                                    'data-confirm' => 'Are you sure to approved this review?',
                                    'title' => 'Approved Review',
                                    'data-bs-toggle' => "tooltip"
                                ]);
                            }
                        },
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>

<?php Pjax::end(); ?>