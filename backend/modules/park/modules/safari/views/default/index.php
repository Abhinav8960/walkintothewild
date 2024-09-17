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
                            return Html::a($model->title, ['/park/safari/default/view', 'safari_park_id' => $model->id], ['style' => 'color: black !important;', 'title' => 'View']);
                        }
                    ],

                    [
                        'label' => 'Safari Cost',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            if (!empty($model->avg_safari_price_min) && !empty($model->avg_safari_price_max)) {
                                return $model->avg_safari_price_min . ' - ' . $model->avg_safari_price_max;
                            } else {
                                return '';
                            }
                        }
                    ],

                    'created_at:dateTime:Created at',
                    'updated_at:dateTime:Last Updated at',
                    [
                        'label' => 'Status',
                        'contentOptions' => ['style' => 'width: 10%; text-align: center;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->newstatuslabel;
                        }
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => "Actions",
                        'contentOptions' => ['style' => 'width: 10%; text-align: center;'],
                        'template' => '&nbsp;{delete}&nbsp;&nbsp;{suspend}',
                        // 'template' => '{view}&nbsp;&nbsp;{delete}&nbsp;&nbsp;{suspend}',

                        'buttons' => [
                            // 'view' => function ($url, $model) {
                            //     return  Html::a('<img src="' . $this->params['baseurl'] . '/img/view.png" alt="" width="25" height="25">
                            //     ', ['/park/safari/default/view', 'safari_park_id' => $model->id], [
                            //         'class' => 'btn p-0 change-menuicon',
                            //         'title' => 'View',

                            //     ]);
                            // },


                            'delete' => function ($url, $model) {
                                if ($model->status != -1) {
                                } else {
                                    return \backend\widgets\SuspendActiveButton::widget(['model' => $model, 'active_title' => 'Safari Park', 'suspend_title' => 'Birding Park']);
                                }
                            },
                            'suspend' => function ($url, $model) {
                                return \backend\widgets\SuspendActiveButton::widget(['model' => $model, 'active_title' => 'Safari Tour Operator', 'suspend_title' => 'Safari Tour Operator']);
                            },
                        ]
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>