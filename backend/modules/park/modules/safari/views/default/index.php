<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\master\office\MasterDepartmentSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Safari Park';
$this->params['breadcrumbs_home_url'] = '#';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
$this->params['buttons'][] = Html::a('+ Create', ['create'], ['class' => 'btn btn-orange ', 'title' => 'Create']);
$this->params['buttons'][] = Html::a('Upload Park CSV', ['/park/safari/default/parkfromfile'], ['class' => 'btn btn-orange', 'title' => 'Upload Park Csv', 'style' => 'margin-left: 4px;']);


?>
<div class="card">

    <div class="card-body">
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        <div id="w1-button" class="mb-3"></div>

        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'label' => 'Title',
                        'contentOptions' => ['style' => 'width: 20%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->title;
                        }
                    ],

                    [
                        'label' => 'Safari Cost',
                        'contentOptions' => ['style' => 'width: 10%;text-align: right;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            if (!empty($model->avg_safari_price_min) && !empty($model->avg_safari_price_max)) {
                                return $model->avg_safari_price_min . ' - ' . $model->avg_safari_price_max;
                            } else {
                                return '';
                            }
                        }
                    ],
                    [
                        'label' => 'Is Publish on Web/App',
                        'contentOptions' => ['style' => 'width: 10%; text-align: center;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            $str = $model->is_published_on_web == 1 ? '<a href="/park/safari/default/publish-on-web?id=' . $model->id . '" class="badge badge-success">Yes</a>' : '<a href="/park/safari/default/publish-on-web?id=' . $model->id . '" class="badge badge-danger">No</a>';
                            $str .= '/';
                            $str .= $model->is_published_on_api == 1 ? '<a href="/park/safari/default/publish-on-api?id=' . $model->id . '" class="badge badge-success">Yes</a>' : '<a href="/park/safari/default/publish-on-api?id=' . $model->id . '" class="badge badge-danger">No</a>';
                            return $str;
                        }
                    ],

                    'created_at:dateTime:Created at',
                    'updated_at:dateTime:Last Updated at',
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
                        'template' => '{view}&nbsp;{delete}&nbsp;&nbsp;{suspend}',
                        // 'template' => '{view}&nbsp;&nbsp;{delete}&nbsp;&nbsp;{suspend}',

                        'buttons' => [
                            'view' => function ($url, $model) {
                                return  Html::a('<img src="' . $this->params['baseurl'] . '/img/view.png" alt="" width="25" height="25">
                                ', ['/park/safari/default/view', 'safari_park_id' => $model->id], [
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