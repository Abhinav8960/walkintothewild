<?php

/* @var $this yii\web\View */
/* @var $model apps\models\employee\Employee */

use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Package : ' . $package_version_model->package_name . '';
$this->params['breadcrumbs_home_url'] = '#';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
$this->params['buttons'][] = Html::Button('+ Add New Gallery Image', ['value' => "/package/profile/create-gallery?package_id=$package_version_model->id", 'class' => 'btn popupButton btn-orange me-2', 'title' => 'Create Gallery']);
?>
<div class="panel panel-primary tabs-style-2">
    <?= $this->render('@backend/modules/package/views/profile/_profile_navbar', ['package' => $package_version_model, 'book_now_active' => 'active']) ?>

    <div class="panel-body tabs-menu-body main-content-body-right border">
        <div class="tab-content">
            <div class="tab-pane active">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <?= GridView::widget([
                                'dataProvider' => $enquire_provider,
                                'columns' => [
                                    [
                                        'class' => 'yii\grid\SerialColumn',
                                        'contentOptions' => ['style' => 'width: 5%;'],
                                    ],
                                    [
                                        'label' => 'Name',
                                        'contentOptions' => ['style' => 'width: 10%;'],
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return $model->name;
                                        }
                                    ],
                                    [
                                        'label' => 'Email',
                                        'contentOptions' => ['style' => 'width: 10%;'],
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return $model->email_address;
                                        }
                                    ],
                                    [
                                        'label' => 'No. of travelers',
                                        'contentOptions' => ['style' => 'width: 10%;'],
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return $model->no_of_travelers;
                                        }
                                    ],
                                    [
                                        'label' => 'Start Date',
                                        'contentOptions' => ['style' => 'width: 10%;'],
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return $model->start_date;
                                        }
                                    ],

                                    [
                                        'label' => 'End Date',
                                        'contentOptions' => ['style' => 'width: 10%;'],
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return $model->end_date;
                                        }
                                    ],


                                    [
                                        'label' => 'Phone',
                                        'contentOptions' => ['style' => 'width: 10%;'],
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            return $model->phone;
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