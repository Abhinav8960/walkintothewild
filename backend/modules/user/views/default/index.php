<?php

use common\models\User;
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'List of Users';
$this->params['breadcrumbs_home_url'] = '/user/default/index';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
if (Yii::$app->user->identity && (Yii::$app->user->identity->is_adminstrator == 1 || Yii::$app->user->identity->is_admin == 1)) {
    $isvisible = true;
    $this->params['buttons'][] = Html::a('<i class="fa fa-plus"></i> Register New User', ['create'], ['class' => 'btn  btn-orange']);
} else {
    $isvisible = false;
}
?>

<?= $this->render('_search', ['model' => $searchModel]) ?>
<div class="card">
    <div class="card-body">

        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'label' => 'Login ID',
                        'contentOptions' => ['style' => 'width: 20%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->username;
                        }
                    ],
                    [
                        'label' => 'Full Name',
                        'contentOptions' => ['style' => 'width: 20%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return Html::a(Html::img($model->avatar != '' ? $model->avatar : '/img/dpmain.png', ['class' => "rounded profile-picture", 'style' => "width:28px;"]) . ' ' . $model->name, ['profile', 'user_id' => $model->id], ['style' => 'color:black !important;']);
                        }
                    ],
                    [
                        'label' => 'Mobile Verified User',
                        'contentOptions' => ['style' => 'width: 20%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            if ($model->is_mobile_no_verified == 1) {
                                return 'Yes';
                            } else {
                                return 'No';
                            }
                        }
                    ],
                    [
                        'label' => 'Role',
                        'contentOptions' => ['style' => 'width: 20%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->rolelabels;
                        }
                    ],
                    [
                        'label' => 'User Flag',
                        'contentOptions' => ['style' => 'width: 20%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->userflaged) ? $model->userflaged->user_flag : '';
                        }
                    ],
                    'created_at:dateTime:Created at',
                    'updated_at:dateTime:Last Updated at',
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
                    [
                        'header' => 'Block',
                        'value' => function ($model) {
                            if ($model->blocked_at) {
                                return Html::a('<i class="fa fa-toggle-on"></i>', ['block', 'id' => $model->id], [
                                    'class' => 'btn btn-xs btn-success',
                                    'data-method' => 'post',
                                    'data-confirm' => 'Are you sure to unblock this user?',
                                    'title' => 'Unblock User',
                                    'data-bs-toggle' => "tooltip"
                                ]);
                            } else {
                                return Html::a('<i class="fa fa-toggle-off"></i>', ['/user/default/block', 'id' => $model->id], [
                                    'class' => 'btn btn-xs btn-warning',
                                    'data-method' => 'post',
                                    'data-confirm' => 'Are you sure to block this user?',
                                    'title' => 'Block User',
                                    'data-bs-toggle' => "tooltip"
                                ]);
                            }
                        },
                        'format' => 'raw',
                        'headerOptions' => ['style' => 'width:5%;'],
                        'contentOptions' => ['style' => 'width:5%;'],
                    ],
                    // [
                    //     'label' => 'Delete',
                    //     'value' => function ($model) {
                    //         return Html::a('<i class="fa fa-user-times"></i>', ['delete', 'id' => $model->id], [
                    //             'class' => 'btn btn-xs btn-danger',
                    //             'data-method' => 'post',
                    //             'data-confirm' => 'Are you sure to delete this user?',
                    //             'title' => 'Delete User',
                    //             'data-bs-toggle' => "tooltip"
                    //         ]);
                    //     },
                    //     'format' => 'raw',
                    //     'headerOptions' => ['style' => 'width:5%;'],
                    //     'contentOptions' => ['style' => 'width:5%;'],
                    //     'visible' => $isvisible,
                    // ],
                ],
            ]); ?>
        </div>
    </div>
</div>