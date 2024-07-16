<?php

/* @var $this yii\web\View */
/* @var $model apps\models\employee\Employee */

use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Package : ' . $package_model->package_name . '';
$this->params['breadcrumbs_home_url'] = '#';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
$this->params['buttons'][] = Html::Button('+ Add FAQ', ['value' => "/package/profile/create-faq?package_id=$package_model->id", 'class' => 'btn popupButton btn-orange me-2', 'title' => 'Create FAQ']);
$this->params['buttons'][] = Html::Button('+ Select FAQ', ['value' => "/package/profile/select-faq?package_id=$package_model->id", 'class' => 'btn popupButton btn-orange', 'title' => 'Select FAQ']);
?>
<div class="panel panel-primary tabs-style-2">
    <?= $this->render('@backend/modules/package/views/profile/_profile_navbar', ['package' => $package_model, 'faq_active' => 'active']) ?>

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
                                        'label' => 'Question',
                                        'contentOptions' => ['style' => 'width: 10%;'],
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return $model->question;
                                        }
                                    ],
                                    [
                                        'label' => 'Answer',
                                        'contentOptions' => ['style' => 'width: 10%;'],
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return $model->answer;
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
                                    [
                                        'class' => 'yii\grid\ActionColumn',
                                        'header' => "Actions",
                                        'contentOptions' => ['style' => 'width: 15%;'],
                                        'template' => '{delete}&nbsp;&nbsp;{suspend}',
                                        'buttons' => [
                                            'delete' => function ($url, $model) {
                                                if ($model->status != -1) {
                                                } else {
                                                    return \backend\widgets\SuspendActiveButton::widget(['model' => $model, 'active_title' => 'Package', 'suspend_title' => 'Pacakge']);
                                                }
                                            },
                                            'suspend' => function ($url, $model) {
                                                return \backend\widgets\SuspendActiveButton::widget(['model' => $model, 'active_title' => 'Package', 'suspend_title' => 'Package']);
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