<?php

use common\models\GeneralModel;
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Safari Tour Operator ';
?>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'contentOptions' => ['style' => 'width: 3%;'],
                    ],
                    [
                        'label' => 'User',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            if ($user = $model->user) {
                                return Html::a(Html::img($user->avatar != '' ? $user->avatar : '/img/dpmain.png', ['class' => "rounded profile-picture", 'style' => "width:28px;"]) . ' ' . $user->name, ['/profile/default/index', 'user_handle' => $user->user_handle]);
                            }
                            return $model->user_id;
                        }
                    ],
                    [
                        'label' => 'Rating',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return  isset($model->safari_operator_rating_id) ? GeneralModel::safarirating()[$model->safari_operator_rating_id] : '';
                        }
                    ],
                    [
                        'label' => 'Report Reason',
                        'contentOptions' => ['style' => 'width: 15%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return  isset($model->report_reason_id) ? GeneralModel::getFlagreasons()[$model->report_reason_id] : '';
                        }
                    ],
                    [
                        'label' => 'Report Detail',
                        'contentOptions' => ['style' => 'width: 20%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->report_detail;
                        }
                    ],
                ],
            ]);
            ?>
        </div>
    </div>
</div>