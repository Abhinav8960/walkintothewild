<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;


$webasset = $this->assetManager->getBundle('\support\assets\NovaAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$this->title = 'Safari Tour Operator';
$this->params['breadcrumbs'][] =  ['label' => 'Operator', 'url' => '#'];
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;


?>

<!-- <?php echo $this->render('_search', ['model' => $searchModel]); ?> -->

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
                        'attribute' => 'business name',
                        'format' => 'raw',
                        'value' => function ($model) {
                            // return Html::a($model->business_name, ['view', 'id' => $model->id], [
                            //     'style' => 'color: black !important;',
                            //     'title' => 'View',
                            // ]);
                            return $model->business_name;
                        },
                        'contentOptions' => ['style' => 'width: 20%; text-align: left;'],
                    ],
                    [
                        'label' => 'Registered Name',
                        'contentOptions' => ['style' => 'width: 15%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->register_comapany_name;
                        }
                    ],
                    [
                        'label' => 'Phone Number',
                        'contentOptions' => ['style' => 'width: 15%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->phone_no;
                        }
                    ],
                    [
                        'label' => 'Email',
                        'contentOptions' => ['style' => 'width: 20%;'],
                        'format' => 'raw',
                        'value' => function ($model) {      
                                return isset($model->email) ? $model->email : '';
                        }
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => "Actions",
                        'contentOptions' => ['style' => 'width: 15%;'],
                        'template' => '{view}&nbsp{temporary}&nbsp{checkin}&nbsp{leads}',
                        'buttons' => [

                            'view' => function ($url, $model) {
                                return  Html::a('<i class="mdi mdi-eye"></i>', ['view', 'id' => $model->id], [
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