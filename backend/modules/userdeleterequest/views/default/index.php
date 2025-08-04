<?php

use common\models\User;
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'List of Delete Requests';
$this->params['title'] = $this->title;

?>

<?= $this->render('_search', ['model' => $searchModel]) ?>

<div class="card">
    <div class="card-body">

        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'headerOptions' => ['style' => 'width: 1%;'],
                    ],
                    [
                        'label' => 'Email',
                        'contentOptions' => ['style' => 'width: 20%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->email;
                        }
                    ],
                    [
                        'label' => 'User Delete Request DateTime',
                        'contentOptions' => ['style' => 'width: 20%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return \Yii::$app->formatter->asDatetime($model->created_at);
                        }
                    ],
                    [
                        'label' => 'Status',
                        'contentOptions' => ['style' => 'width: 15%; text-align: left;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            if($model->user->status == 10){
                                return '<img src="' . $this->params['baseurl'] . '/img/Active.png" alt="" style="width: 60px;height: 60px;object-fit: contain;">';
                            }
                            elseif($model->user->status == 9){
                                return '<img src="' . $this->params['baseurl'] . '/img/Inactive.png" alt="" style="width: 60px;height: 60px;object-fit: contain;">';
                            }
                            return '';
                        }
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>