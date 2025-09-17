<?php

use yii\grid\GridView;
use yii\helpers\Html;

$webasset = $this->assetManager->getBundle('\business\assets\PartnerAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
$this->title = 'Fixed Departure';
?>

<div class="title">
    <p style="font-weight: 700; font-size:25px"><?= $this->title ?></p>
</div>
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
                        'label' => 'User Name',
                        'contentOptions' => ['style' => 'width: 5%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            if ($user = $model->user) {
                                $name = $user->name ?? '';
                                $imageUrl = $user->profile_display_image ?:  $this->params['baseurl'] . '/images/dpmain.png';
                                return
                                    Html::img($imageUrl, [
                                        'class' => "rounded profile-picture",
                                        'style' => "width:28px;"
                                    ]) . ' ' . Html::encode($name);
                            }
                            return '';
                        }
                    ],
                    [
                        'label' => 'Fixed Departure',
                        'contentOptions' => ['style' => 'width: 5%;'],

                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->fixedDeparture ? $model->fixedDeparture->share_safari_title : '';
                        }
                    ],

                    [
                        'label' => 'Start Date',
                        'contentOptions' => ['style' => 'width: 5%;'],

                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->fixedDeparture ? $model->fixedDeparture->start_date : '';
                        }
                    ],

                    [
                        'label' => 'End Date',
                        'contentOptions' => ['style' => 'width: 5%;'],

                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->fixedDeparture ? $model->fixedDeparture->end_date : '';
                        }
                    ],

                    [
                        'label' => 'Cut Off Date',
                        'contentOptions' => ['style' => 'width: 5%;'],

                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->fixedDeparture ? $model->fixedDeparture->cut_off_date : '';
                        }
                    ],

                    [
                        'label' => 'No of Safari',
                        'contentOptions' => ['style' => 'width: 5%;'],

                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->fixedDeparture ? $model->fixedDeparture->no_of_safari : '';
                        }
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => "Actions",
                        'contentOptions' => ['style' => 'width: 5%; text-align: left;'],
                        'template' => '{view}',
                        'buttons' => [

                            'view' => function ($url, $model) {
                                return  Html::a('<i class="mdi mdi-eye"></i>', ['/fixeddeparturechat/default/view', 'id' => $model->id], [
                                    'class' => 'action-icon',
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