<?php

use common\models\GeneralModel;
use common\models\package\PackageVersion;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\support\assets\NovaAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$this->title = 'Package';
$this->params['title'] = $this->title;
?>


<?php echo $this->render('_search', ['model' => $searchModel]); ?>
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
                        'headerOptions' => ['style' => 'width: 5%;'],
                    ],
                    [
                        'label' => 'Package Name',
                        'headerOptions' => ['style' => 'width: 15%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return mb_strimwidth($model->package_name, 0, 40, "...");
                        }
                    ],
                    [
                        'label' => 'Duration',
                        'headerOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->no_of_day . ' Days, ' . $model->no_of_night . ' Nights';
                        }
                    ],
                    [
                        'label' => 'Cost Per Person',
                        'headerOptions' => ['style' => 'width: 10%;'],
                        'contentOptions' => ['style' => 'text-align: center;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return GeneralModel::number_format_indian($model->cost_per_person);
                        }
                    ],
                    [
                        'label' => 'No of Safari',
                        'headerOptions' => ['style' => 'width: 10%;'],
                        'contentOptions' => ['style' => 'text-align: center;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->no_of_safari;
                        }
                    ],
                    [
                        'label' => 'Stay Category',
                        'headerOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->stay_category_id) ? GeneralModel::packagemetastaycategory()[$model->stay_category_id] : '';
                        }
                    ],
                    [
                        'label' => 'Max Booking Date',
                        'headerOptions' => ['style' => 'width: 12%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->max_booking_date) ? date("F j, Y, g:i a", strtotime($model->max_booking_date)) : '';
                        }
                    ],

                    [
                        'label' => 'Status',
                        'contentOptions' => ['style' => 'width: 10%; text-align: left;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->livestatustags;
                        }
                    ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => "Actions",
                        'headerOptions' => ['style' => 'width: 10%;'],
                        'contentOptions' => ['style' => 'width: 10%; text-align: left;'],
                        'template' => '{view}&nbsp;&nbsp;',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return  Html::a('<i class="mdi mdi-eye"></i>', ['/package/default/view', 'id' => $model->id], [
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