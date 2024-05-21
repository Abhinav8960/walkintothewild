<?php

use common\models\User;
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'List of Users';
$this->params['breadcrumbs_home_url'] = '/user/default/index';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
if (Yii::$app->user->identity && Yii::$app->user->identity->is_adminstrator == 1) {
    $isvisible = true;
    $this->params['buttons'][] = Html::a('<i class="fa fa-plus"></i> Register New User', ['create'], ['class' => 'btn  btn-orange']);
} else {
    $isvisible = false;
}
?>
<div class="card">

    <div class="card-body">
        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'tableOptions' => ['class' => 'table table-vcenter text-nowrap table-bordered border-bottom dataTable no-footer'],
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'header' => 'S.No.'
                    ],
                    'username:raw:Login ID',
                    'name:raw:Full Name',
                    'email:raw:Email',
                    'rolelabel:raw:Role',
                    'created_at:datetime:Created At',
                    'password_update_at:relativeTime:Last Password Update',
                    [
                        'label' => 'Update',
                        'value' => function ($model) {
                            return Html::a('<i class="fa fa-edit text-white"></i>', ['/user/default/update?user_id=' . $model->id], ['class' => 'btn btn-info', 'title' => 'Update User', 'data-bs-toggle' => "tooltip"]);
                        },
                        'format' => 'raw',
                        'headerOptions' => ['style' => 'width:5%;'],
                        'contentOptions' => ['style' => 'width:5%;'],
                        'visible' => $isvisible,
                    ],
                    // [
                    //     'header' => 'Block',
                    //     'value' => function ($model) {
                    //         if ($model->blocked_at) {
                    //             return Html::a('<i class="fa fa-toggle-on"></i>', ['block', 'id' => $model->id], [
                    //                 'class' => 'btn btn-xs btn-success',
                    //                 'data-method' => 'post',
                    //                 'data-confirm' => 'Are you sure to unblock this user?',
                    //                 'title' => 'Unblock User', 'data-bs-toggle' => "tooltip"
                    //             ]);
                    //         } else {
                    //             return Html::a('<i class="fa fa-toggle-off"></i>', ['/user/default/block', 'id' => $model->id], [
                    //                 'class' => 'btn btn-xs btn-danger',
                    //                 'data-method' => 'post',
                    //                 'data-confirm' => 'Are you sure to block this user?',
                    //                 'title' => 'Block User', 'data-bs-toggle' => "tooltip"
                    //             ]);
                    //         }
                    //     },
                    //     'format' => 'raw',
                    //     'headerOptions' => ['style' => 'width:5%;'],
                    //     'contentOptions' => ['style' => 'width:5%;'],
                    // ],

                    [
                        'label' => 'Switch',
                        'value' => function ($model) {
                            return Html::a(' <i class="mdi mdi-account-switch text-white"></i>', ['/user/default/switchidentity?id=' . $model->id], ['class' => 'btn btn-info btn-secondary']);
                        },
                        'format' => 'raw',
                        'headerOptions' => ['style' => 'width:5%;'],
                        'contentOptions' => ['style' => 'width:5%;'],
                        'visible' => $isvisible,
                    ],
                ],
            ]);  ?>

        </div>
    </div>
</div>