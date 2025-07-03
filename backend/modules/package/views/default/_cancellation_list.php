<?php


use common\models\GeneralModel;
use common\models\package\PackageVersion;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Package Reject List';
$this->params['title'] = $this->title;
?>


<div class="card">
    <div class="card-body">
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        <div id="w1-button" class="mb-3"></div>

        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'contentOptions' => ['style' => 'width: 5%;'],
                    ],
                    [
                        'label' => 'Package Name',
                        'headerOptions' => ['style' => 'width: 15%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->package_name;
                        }
                    ],
                    [
                        'label' => 'Partner Name',
                        'contentOptions' => ['style' => 'width: 15%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->safarioperator) ? $model->safarioperator->business_name : '';
                        }
                    ],
                    [
                        'label' => 'Cost Per Person',
                        'headerOptions' => ['style' => 'width: 15%;'],
                        'contentOptions' => ['style' => 'text-align: right;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return GeneralModel::number_format_indian($model->cost_per_person);
                        }
                    ],
                    [
                        'label' => 'Stay Category',
                        'headerOptions' => ['style' => 'width: 15%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->stay_category_id) ? GeneralModel::packagemetastaycategory()[$model->stay_category_id] : '';
                        }
                    ],

                    [
                        'label' => 'Feature',
                        'format' => 'raw',
                        'value' => function ($model) {
                            $html = '';
                            $features = $model->packagefeatures;
                            foreach ($features as $key => $feature) {
                                if (isset(GeneralModel::packagefeatureoption()[$feature->feature_id])) {
                                    $html .= GeneralModel::packagefeatureoption()[$feature->feature_id] . ', ';
                                }
                            }
                            return $html;
                        }
                    ],

                    [
                        'label' => 'Included',
                        'format' => 'raw',
                        'value' => function ($model) {
                            $html = '';
                            $included = $model->packageincluded;
                            foreach ($included as $key => $data) {
                                if (isset(GeneralModel::packageincludeoption()[$data->include_id])) {
                                    $html .= GeneralModel::packageincludeoption()[$data->include_id] . ', ';
                                }
                            }
                            return $html;
                        }
                    ],
                    [
                        'label' => 'Package Name',
                        'headerOptions' => ['style' => 'width: 15%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->cancellation_reason;
                        }
                    ],

                ],
            ]); ?>
        </div>
    </div>
</div>