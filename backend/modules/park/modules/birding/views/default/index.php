<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\master\office\MasterDepartmentSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Birding Park';
$this->params['breadcrumbs_home_url'] = '#';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
$this->params['buttons'][] = Html::a('+ Create', ['create'], ['class' => 'btn btn-orange ', 'title' => 'Create']);
$this->params['buttons'][] = Html::a('Upload Park CSV', ['/park/birding/default/parkfromfile'], ['class' => 'btn btn-orange', 'title' => 'Upload Park Csv', 'style' => 'margin-left: 4px;']);


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
                    'title',

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
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->statuslabel;
                        }
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => "Actions",
                        'contentOptions' => ['style' => 'width: 15%;'],
                        'template' => '{view}&nbsp;&nbsp;{delete}',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return  Html::a('<img src="/img/view.png" alt="" width="25" height="25">
                                ', ['/park/birding/profile', 'birding_park_id' => $model->id], [
                                    'class' => 'btn p-0 change-menuicon',
                                    'title' => 'View',

                                ]);
                            },

                            'delete' => function ($url, $model) {
                                return  Html::a('<img src="/img/delete.png" alt="" width="25" height="25">', ['delete', 'id' => $model->id], [
                                    'class' => 'btn p-0 change-menuicon',
                                    'title' => 'Delete',
                                    'data' => [
                                        'confirm' => 'Are you sure you want to delete  ' . $model->title . '?',
                                        'method' => 'post',
                                    ],
                                ]);
                            },
                        ]
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>