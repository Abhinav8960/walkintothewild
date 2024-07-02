<?php

use common\models\GeneralModel;
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Safari Tour Operator : ' . $model->business_name;
$this->params['breadcrumbs_home_url'] = '/operator/safari-operator';
$this->params['breadcrumbs'][] =  ['label' => 'Operator', 'url' => '#'];
$this->params['breadcrumbs'][] = 'View';
$this->params['title'] = $this->title;

?>
<div class="panel panel-primary tabs-style-2">
    <?= $this->render('@backend/modules/operator/views/safari-operator/_navbar.php', ['model' => $model, 'active_navbar' => 'review']) ?>

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
                                        'contentOptions' => ['style' => 'width: 15%;'],
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            if ($user = $model->user) {
                                                return Html::img($user->avatar != '' ? $user->avatar : '/img/dpmain.png', ['class' => "rounded profile-picture", 'style' => "width:28px;"]) . ' ' . $user->name;
                                            }
                                            return $model->user_id;
                                        }
                                    ],

                                    [
                                        'label' => 'Safari Operator',
                                        'contentOptions' => ['style' => 'width: 15%;'],
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return  isset($model->safari_operator_id) ? GeneralModel::safariparkoperatoroption()[$model->safari_operator_id] : '';
                                        }
                                    ],
                                    [
                                        'label' => 'Park',
                                        'contentOptions' => ['style' => 'width: 15%;'],
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return  isset($model->park_id) ? GeneralModel::safariparkoption()[$model->park_id] : '';
                                        }
                                    ],
                                    [
                                        'label' => 'Rating',
                                        'contentOptions' => ['style' => 'width: 20%;'],
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
                                        'label' => 'Flaged',
                                        'contentOptions' => ['style' => 'width: 15%;'],
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return ($model->flaged == 1) ? 'Yes' : 'No';
                                        }
                                    ],
                                    [
                                        'class' => 'yii\grid\ActionColumn',
                                        'header' => "Actions",
                                        'contentOptions' => ['style' => 'width: 15%;'],
                                        'template' => '{view}&nbsp{update}&nbsp{suspend}',
                                        'buttons' => [
                                            'view' => function ($url, $model) {
                                                return   Html::Button('<img src="/img/view.png" alt="" width="25" height="25">', ['value' => "/operator/safari-operator/flagview?id=$model->id&safari_operator_id=$model->safari_operator_id", 'class' => 'btn popupButton', 'title' => 'View Flages']);
                                            },

                                        ]
                                    ],

                                ],
                            ]);
                            ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .text-box p span {
        color: brown !important;
    }
</style>