<?php

use yii\grid\GridView;
$this->title = $safari_operator->business_name . ' | Manage Operator Business';

?>

<div class="container-fluid mt-5 ">
    <div class="row margin_bottomfooter">
        <div class="col-md-12">
        <h6 class="fs-3 fw-bold mb-4"><?= $this->title ?></h6>
        </div>
        <div class="col-md-2">
            <?= $this->render('@frontend/modules/manage/views/default/_sidebar', ['active' => 'quote']); ?>
        </div>
        <div class="col-md-10">
            <div class="card account-settingside">
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive table_design_manage">
                                <?= GridView::widget([
                                    'dataProvider' => $dataProvider,
                                    'columns' => [
                                        [
                                            'class' => 'yii\grid\SerialColumn',
                                            'contentOptions' => ['style' => 'width: 2%;'],
                                        ],
                                        'park.title:raw:Park Name',
                                        [
                                            'label' => 'Name',
                                            'contentOptions' => ['style' => 'width: 10%;'],
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return $model->full_name;
                                            }
                                        ],
                                        [
                                            'label' => 'Email',
                                            'contentOptions' => ['style' => 'width: 10%;'],
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return $model->email;
                                            }
                                        ],
                                        [
                                            'label' => 'Phone Number',
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return $model->phone_no;
                                            }
                                        ],
                                        [
                                            'label' => 'Safaris',
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return $model->safaris;
                                            }
                                        ],
                                        [
                                            'label' => 'Travelers',
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return $model->travelers;
                                            }
                                        ],
                                        'staycatgory.title:raw:Stay Category',
                                        [
                                            'label' => 'Start Date',
                                            'contentOptions' => ['style' => 'width: 5%;'],
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return $model->start_date;
                                            }
                                        ],
                                        [
                                            'label' => 'End Date',
                                            'contentOptions' => ['style' => 'width: 5%;'],
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return $model->end_date;
                                            }
                                        ],
                                        [
                                            'label' => 'Request Time',
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