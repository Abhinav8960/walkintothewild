<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = $safari_operator->business_name . ' | Manage Operator Business';

?>

<div class="container mt-5 mb-5">
    <div class="row mb-5">
        <div class="col-md-12 d-flex justify-content-between">
            <h5><?= $this->title ?></h5>
            <div class="right_button float-md-end">
                <a href="#<?= Url::toRoute(['/manage/package/create']) ?>" class="btn_newsafari packageBtn"><i class="fa fa-plus"></i> Create New Package</a>
            </div>
        </div>
        <div class="col-md-3">
            <?= $this->render('@frontend/modules/manage/views/default/_sidebar', ['active' => 'package']); ?>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <?= GridView::widget([
                                    'dataProvider' => $dataProvider,
                                    'columns' => [
                                        [
                                            'class' => 'yii\grid\SerialColumn',
                                            'contentOptions' => ['style' => 'width: 2%;'],
                                        ],
                                        [
                                            'label' => 'Package Name',
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return Html::a($model->package_name, ['/package/default/view', 'slug' => $model->package_slug]);
                                            }
                                        ],
                                        [
                                            'label' => 'No of Day',
                                            'contentOptions' => ['style' => 'width: 10%;'],
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return $model->no_of_day;
                                            }
                                        ],
                                        [
                                            'label' => 'No of Safari',
                                            'contentOptions' => ['style' => 'width: 10%;'],
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return $model->no_of_safari;
                                            }
                                        ],
                                        [
                                            'label' => 'Start Date',
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return $model->start_date;
                                            }
                                        ],
                                        [
                                            'label' => 'End Date',
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return $model->end_date;
                                            }
                                        ],
                                        [
                                            'label' => 'Price',
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return $model->cost_per_person;
                                            }
                                        ],
                                        [
                                            'label' => 'Created At',
                                            'contentOptions' => ['style' => 'width: 5%;'],
                                            'format' => 'dateTime',
                                            'value' => function ($model) {
                                                return $model->created_at;
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
</div>