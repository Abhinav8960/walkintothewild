<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;


$this->title = 'Profile : ' . $user->username;
$this->params['breadcrumbs_home_url'] = '/user/default/index';
$this->params['breadcrumbs'][] =  ['label' => 'User', 'url' => '#'];
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
?>
<div class="row">
    <div class="col-md-12">
        <div class="card card-default">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2">
                        <?= Html::img($user->profile_display_image ? $user->profile_display_image : $this->params['baseurl'] . '/img/dpmain.png', ['class' => "rounded profile-picture", 'style' => "width:100%; height:auto;"]) ?>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Login ID :</strong> <?= $user->username ?></p>
                        <p><strong>Name :</strong> <?= $user->name ?></p>
                        <p><strong>Joined At : </strong><?= date('Y-m-d h:i:s', $user->created_at) ?></p>
                        <p><strong>Roles :</strong><?= $user->rolelabels ?></p>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex justify-content-between">
                            <?= Html::a('<i class="fa fa-eye text-white"></i> View Complete Profile', Yii::$app->params['frontend_url'] . '/profile/user/' . $user->user_handle, ['target' => "_blank", 'class' => 'btn btn-success', 'title' => 'View User Profile', 'data-bs-toggle' => "tooltip"]) ?>
                        </div>
                    </div>
                    <div class="col-md-12 mt-5">

                        <div class="row">
                            <div class="col-md-6">
                                <h3>Followers List</h3>
                                <?php
                                Pjax::begin([
                                    'id' => 'grid-data',
                                    'enablePushState' => FALSE,
                                    'enableReplaceState' => FALSE,
                                    'timeout' => false,
                                ]);
                                ?>
                                <div class="table-wrapper">
                                    <div class="table-responsive">
                                        <div class="min-width-table">
                                            <?= GridView::widget([
                                                'dataProvider' => $dataProvider,
                                                'layout' => "{items}\n<div class='row align-items-center mt-3'>
                                                            <div class='col-md-4 text-start mb-2'>{summary}</div>
                                                            <div class='col-md-4 text-center mb-2'>{pager}</div>
                                                            <div class='col-md-4'></div>
                                                            </div>",
                                                'tableOptions' => ['class' => 'table tablecustoms table-striped align-middle w-100'],
                                                'columns' => [
                                                    [
                                                        'class' => 'yii\grid\SerialColumn',
                                                        'headerOptions' => ['style' => 'width: 1%;'],
                                                    ],
                                                    [
                                                        'label' => 'Full Name',
                                                        'contentOptions' => ['style' => 'width: 30%;'],
                                                        'format' => 'raw',
                                                        'value' => function ($model) {
                                                            return Html::a(Html::img($model->user->profile_display_image ? $model->user->profile_display_image : $this->params['baseurl'] . '/img/dpmain.png', ['class' => "rounded profile-picture", 'style' => "width:28px;"]) . ' ' . $model->user->name, ['profile', 'user_id' => $model->user->id], ['style' => 'color:black !important;', 'data-pjax' => "0"]);
                                                        }
                                                    ],
                                                    'created_at:dateTime:Following Start at',
                                                    'user.created_at:dateTime:Joined at',
                                                ],
                                            ]); ?>
                                        </div>
                                    </div>
                                </div>
                                <?php Pjax::end(); ?>
                            </div>
                            <div class="col-md-6">
                                <?php
                                Pjax::begin([
                                    'id' => 'grid-data-following',
                                    'enablePushState' => FALSE,
                                    'enableReplaceState' => FALSE,
                                    'timeout' => false,
                                ]);
                                ?>
                                <h3>Following List</h3>
                                <div class="table-wrapper">
                                    <div class="table-responsive">
                                        <div class="min-width-table">
                                            <?= GridView::widget([
                                                'dataProvider' => $following_dataProvider,
                                                'layout' => "{items}\n<div class='row align-items-center mt-3'>
                                                            <div class='col-md-4 text-start mb-2'>{summary}</div>
                                                            <div class='col-md-4 text-center mb-2'>{pager}</div>
                                                            <div class='col-md-4'></div>
                                                            </div>",
                                                'tableOptions' => ['class' => 'table tablecustoms table-striped align-middle w-100'],
                                                'columns' => [
                                                    [
                                                        'class' => 'yii\grid\SerialColumn',
                                                        'headerOptions' => ['style' => 'width: 1%;'],
                                                    ],
                                                    [
                                                        'label' => 'Full Name',
                                                        'contentOptions' => ['style' => 'width: 30%;'],
                                                        'format' => 'raw',
                                                        'value' => function ($model) {
                                                            return Html::a(Html::img($model->follower->profile_display_image ? $model->follower->profile_display_image : $this->params['baseurl'] . '/img/dpmain.png', ['class' => "rounded profile-picture", 'style' => "width:28px;"]) . ' ' . $model->follower->name, ['profile', 'user_id' => $model->follower->id], ['style' => 'color:black !important;', 'data-pjax' => "0"]);
                                                        }
                                                    ],
                                                    'created_at:dateTime:Following Start at',
                                                    'follower.created_at:dateTime:Joined at',
                                                ],
                                            ]); ?>
                                        </div>
                                    </div>
                                </div>
                                <?php Pjax::end(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>