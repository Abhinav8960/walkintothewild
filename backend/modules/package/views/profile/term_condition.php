<?php

/* @var $this yii\web\View */
/* @var $model apps\models\employee\Employee */

use yii\grid\GridView;
use yii\helpers\Html;


$this->title = 'Package : ' . $package_model->package_name . '';
$this->params['breadcrumbs_home_url'] = '#';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
$this->params['buttons'][] = Html::a('+ Create Term & Condition', ['create-term-condition', 'package_id' => $package_model->id], ['class' => 'btn btn-orange ', 'title' => 'Create Term & Condition']);
?>
<div class="panel panel-primary tabs-style-2">
    <?= $this->render('@backend/modules/package/views/profile/_profile_navbar', ['package' => $package_model, 'term_condition_active' => 'active']) ?>

    <div class="panel-body tabs-menu-body main-content-body-right border">
        <div class="tab-content">
            <div class="tab-pane active">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <?= GridView::widget([
                                'dataProvider' => $dataProvider,
                                'columns' => [
                                    [
                                        'class' => 'yii\grid\SerialColumn',
                                        'contentOptions' => ['style' => 'width: 5%;'],
                                    ],
                                    [
                                        'label' => 'Title',
                                        'contentOptions' => ['style' => 'width: 20%;'],
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return $model->title;
                                        }
                                    ],
                                    [
                                        'attribute' => 'Description',
                                        'contentOptions' => ['style' => 'width: 20%;'],
                                        'format' => 'html',
                                        'enableSorting' => true,
                                        'value' => function ($model) {
                                            return isset($model) ? substr($model->description, 0, 50) : '';
                                        },
                                        'contentOptions' =>  function ($model) {
                                            return  isset($model->description) ? ['title' => $model->description, 'data-toggle' => 'tooltip'] : null;
                                        },
                                    ],

                                    [
                                        'label' => 'Status',
                                        'contentOptions' => ['style' => 'width: 10%;'],
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return $model->statuslabel;
                                        }
                                    ],
                                    [
                                        'class' => 'yii\grid\ActionColumn',
                                        'header' => "Actions",
                                        'contentOptions' => ['style' => 'width: 15%;'],
                                        'template' => '{update}',
                                        'buttons' => [
                                            'update' => function ($url, $model) {
                                                return  Html::a('<img src="/img/update.png" alt="" width="25" height="25">
                            ', ['/package/profile/update-term-condition', 'package_id' => $model->package_id, 'id' => $model->id], [
                                                    'class' => 'btn p-0 change-menuicon',
                                                    'title' => 'View',

                                                ]);
                                            },
                                        ]
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