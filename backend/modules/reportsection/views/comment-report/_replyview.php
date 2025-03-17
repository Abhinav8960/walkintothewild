<?php


use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

?>

<?php
Pjax::begin([
    'id' => 'grid-data',
    'enablePushState' => FALSE,
    'enableReplaceState' => FALSE,
    'timeout' => false,
]);
?>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'label' => 'User',
                        'contentOptions' => ['style' => 'width: 20%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            if ($user = $model->user) {
                                return Html::img($user->avatar != '' ? $user->avatar : '/img/dpmain.png', ['class' => "rounded profile-picture", 'style' => "width:28px;"]) . ' ' . $user->name;
                            }
                            return $model->user_id;
                        }
                    ],
                    'comment',
                ]
            ]); ?>
        </div>
    </div>
</div>