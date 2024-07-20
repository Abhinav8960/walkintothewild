<?php

use common\models\trierror\FrontendRequestLog;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\trierror\FrontendRequestLogSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Frontend Request Log';
$this->params['breadcrumbs_home_url'] = '/';
$this->params['breadcrumbs'][] =  ['label' => 'trierror', 'url' => '#'];
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
?>

<div class="card">
    <div class="card-body">
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        <div id="w1-button" class="mb-3"></div>
        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                //'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'label' => 'User',
                        'format' => 'raw',
                        'value' => function ($model) {
                            if(!empty($model->user_id)){
                                //$model->user->name
                                return $model->user->name." ". Html::a('<img src="/img/view.png" alt="" width="25" height="25">
                                ', ['/trierror/frontend-request-log/user-view', 'id' => $model->user_id], [
                                    'class' => 'btn p-0 change-menuicon',
                                    'title' => 'View',
                                ]);
                            }else{
                                return '-';
                            }
                        }
                    ],
                    [
                        'label' => 'Slug',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->slug;
                        }
                    ],
                    [
                        'label' => 'Request Url',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->request_url;
                        }
                    ],
                    [
                        'label' => 'Code',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->request_code;
                        }
                    ],
                    [
                        'label' => 'Method',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->request_type;
                        }
                    ],
                    [
                        'label' => 'Device',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->system;
                        }
                    ],
                    [
                        'label' => 'Created At',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return date('d/m/Y H:i', strtotime($model->created_at));
                        }
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        //'header' => "Actions",
                        //'contentOptions' => ['style' => 'width: 15%;'],
                        'template' => '{view}&nbsp;&nbsp;{delete}&nbsp;&nbsp;{suspend}',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return  Html::a('<img src="/img/view.png" alt="" width="25" height="25">
                                ', ['/trierror/frontend-request-log/view', 'id' => $model->id], [
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
