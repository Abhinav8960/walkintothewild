<?php

/* @var $this yii\web\View */
/* @var $model apps\models\employee\Employee */

use common\models\GeneralModel;
use yii\helpers\Html;

use yii\grid\GridView;

$this->title = 'Safari Park Gallery';
$this->params['breadcrumbs_home_url'] = '#';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
?>
<div class="panel panel-primary tabs-style-2">
    <?= $this->render('@backend/modules/park/modules/safari/views/profile/_profile_navbar', ['safari_park' => $safari_model, 'reviews_active' => 'active']) ?>

    <div class="panel-body tabs-menu-body main-content-body-right border">
        <div class="tab-content">
            <div class="tab-pane active">
                <div class="card">

                    <div class="card-body">
                        <div class="table-responsive">
                            <?= GridView::widget([
                                'dataProvider' => $dataProvider,
                                'columns' => [
                                    ['class' => 'yii\grid\SerialColumn'],

                                    [
                                        'label' => 'User',
                                        'contentOptions' => ['style' => 'width:20%;'],
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            if ($user = $model->user) {
                                                return Html::img($user->avatar != '' ? $user->avatar : '/img/dpmain.png', ['class' => "rounded profile-picture", 'style' => "width:28px;"]) . ' ' . $user->name;
                                            }
                                            return $model->user_id;
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
                                        'label' => 'Review',
                                        'contentOptions' => ['style' => 'width: 20%;'],
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return $model->review;
                                        }
                                    ],
                                    [
                                        'label' => 'Created At',
                                        'contentOptions' => ['style' => 'width: 10%;'],
                                        'format' => 'dateTime',
                                        'value' => function ($model) {
                                            return $model->created_at;
                                        }
                                    ],
                                    [
                                        'label' => 'Updated At',
                                        'contentOptions' => ['style' => 'width: 10%;'],
                                        'format' => 'dateTime',
                                        'value' => function ($model) {
                                            return $model->updated_at;
                                        }
                                    ],

                                    [
                                        'label' => 'Status',
                                        'contentOptions' => ['style' => 'width: 10%;'],
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return $model->statuslabel;
                                        }
                                    ],
                                ],
                            ]); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>