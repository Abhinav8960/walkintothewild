<?php


use common\models\GeneralModel;
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Package';
$this->params['title'] = $this->title;

$this->params['baseurl'] = $this->assetManager->getBundle('\backend\assets\NovaAppAsset')->baseUrl;
?>


<div class="card">
    <div class="card-body">
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        <div id="w1-button" class="mb-3"></div>

        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                // 'layout' => "{items}\n{summary}\n{pager}",
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'headerOptions' => ['style' => 'width: 5%;'],
                    ],
                    [
                        'label' => 'Package Name',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->package_name;
                        }
                    ],

                    [
                        'label' => 'Partner Name',
                        'format' => 'raw',
                        'value' => function ($model) {
                            $imageUrl = isset($model->safarioperator->imagepath) ? $model->safarioperator->imagepath : $this->params['baseurl'] . '/img/NewBanner_big.png';
                            $name = isset($model->safarioperator) ? $model->safarioperator->business_name : '';
                            return '<img src="' . $imageUrl . '" alt="" style="max-height:30px;"> ' . Html::encode($name);
                        },
                    ],
                    [
                        'label' => 'Stay Category',
                        'headerOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->stay_category_id) ? GeneralModel::packageoption()[$model->stay_category_id] : '';
                        }
                    ],
                    [
                        'label' => 'Cost Per Person',
                        'headerOptions' => ['style' => 'width: 10%;'],
                        'contentOptions' => ['style' => 'text-align: right;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return GeneralModel::number_format_indian($model->cost_per_person);
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
                        'label' => 'Updated Date',
                        'headerOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return date("F j, Y, g:i a", $model->updated_at);
                        }
                    ],
                    // [
                    //     'label' => 'Is Publish on Web/App',
                    //     'contentOptions' => ['style' => 'width: 10%; text-align: center;'],
                    //     'format' => 'raw',
                    //     'value' => function ($model) {
                    //         $str = $model->is_published_on_web == 1 ? '<a href="/package/default/publish-on-web?id=' . $model->id . '" class="badge badge-success">Yes</a>' : '<a href="/package/default/publish-on-web?id=' . $model->id . '" class="badge badge-danger">No</a>';
                    //         $str .= '/';
                    //         $str .= $model->is_published_on_api == 1 ? '<a href="/package/default/publish-on-api?id=' . $model->id . '" class="badge badge-success">Yes</a>' : '<a href="/package/default/publish-on-api?id=' . $model->id . '" class="badge badge-danger">No</a>';
                    //         return $str;
                    //     }
                    // ],
                    [
                        'label' => 'Status',
                        'contentOptions' => ['style' => 'width: 10%; text-align: left;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->newstatuslabel;
                        }
                    ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => "Actions",
                        'contentOptions' => ['style' => 'width: 10%; text-align: left;'],
                        'template' => '{view}',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return  Html::a('<img src="' . $this->params['baseurl'] . '/img/view.png" alt="" width="25" height="25">
                                ', ['/package/preview/index', 'id' => $model->id], [
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