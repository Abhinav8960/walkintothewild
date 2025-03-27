<?php

use yii\helpers\Html;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\trierror\ApiRequestLogSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'API Request Log';
$this->params['breadcrumbs_home_url'] = '/';
$this->params['breadcrumbs'][] =  ['label' => 'trierror', 'url' => '#'];
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
?>
<style>
    .table a {
        color: #0000EE !important;
        text-align: left !important;
    }
</style>
<div class="card">
    <div class="card-body">
        <?php echo $this->render('_search', ['model' => $searchModel, 'request_codes_list' => $request_codes_list, 'request_group_type' => $request_group_type]); ?>
        <div id="w1-button" class="mb-3"></div>
        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                //'filterModel' => $searchModel,
                //'options' => ['style' => 'table-layout:fixed;'],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'label' => 'User',
                        'format' => 'raw',
                        'contentOptions' => ['style' => 'color:#000;'],
                        'value' => function ($model) {
                            if (!empty($model->user_id)) {
                                return Html::a(
                                    $model->user->name,
                                    [
                                        '/trierror/api-request-log/user-view',
                                        'id' => $model->user_id
                                    ],
                                    [
                                        'class' => 'btn p-0 change-menuicon',
                                        'title' => 'View',
                                        'target' => '_blank'

                                    ]
                                );
                            } else {
                                return '-';
                            }
                        }
                    ],
                    // [
                    //     'label' => 'Module',
                    //     'format' => 'raw',
                    //     'value' => function ($model) {
                    //         return ucwords($model->request_group);
                    //     }
                    // ],
                    [
                        'label' => 'Slug',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->slug;
                        }
                    ],
                    [
                        'label' => 'URL',
                        'format' => 'raw',
                        'contentOptions' => ['style' => 'color:#000;'],
                        'value' => function ($model) {
                            $short_url = \common\models\GeneralModel::getshorturl($model->request_full_url);
                            $temp = "<a target='_blank' href='" . $model->request_full_url . "'>" . $short_url . "</a>";
                            return $temp;
                        }
                    ],
                    [
                        'label' => 'Request Code',
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
                    // [
                    //     'label' => 'Device',
                    //     'format' => 'raw',
                    //     'value' => function ($model) {
                    //         return $model->system;
                    //     }
                    // ],
                    [
                        'label' => 'Response Status',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->response_error;
                        }
                    ],
                    // [
                    //     'label' => 'is count',
                    //     'format' => 'raw',
                    //     'value' => function ($model) {
                    //         return $model->is_count;
                    //     }
                    // ],
                    // [
                    //     'label' => 'is traced',
                    //     'format' => 'raw',
                    //     'value' => function ($model) {
                    //         return $model->is_reqeust_trace;
                    //     }
                    // ],
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
                        'template' => '{view}&nbsp;&nbsp;',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return  Html::a('<img src="' . $this->params['baseurl'] . '/img/view.png" alt="" width="25" height="25">
                                ', ['/trierror/api-request-log/view', 'id' => $model->id], [
                                    'class' => 'btn p-0 change-menuicon',
                                    'title' => 'View',
                                ]);
                            },
                            /*
                            'delete' => function ($url, $model) {
                                return  Html::a('<img src="' . $this->params['baseurl'] . '/img/red_delete.png" alt="" width="25" height="25">
                                ', ['/trierror/api-request-log/delete', 'id' => $model->id], [
                                    'class' => 'btn p-0 change-menuicon',
                                    'title' => 'View',
                                    'data' => [
                                        'confirm' => 'Are you sure you want to delete this records ?',
                                        'method' => 'post',
                                        //'id' => $model->id
                                    ],
                                ]);
                            },
                            */
                        ]
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>