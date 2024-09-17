<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\master\office\MasterDepartmentSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Operator Quote';
$this->params['breadcrumbs_home_url'] = '#';
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
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'label' => 'Park',
                        'contentOptions' => ['style' => 'width: 15%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset(GeneralModel::safariparkoption()[$model->safari_park_id]) ? Html::a(
                                GeneralModel::safariparkoption()[$model->safari_park_id],
                                ['/park/operator-quote/view', 'id' => $model->id],
                                ['style' => 'color: black !important;', 'title' => 'View Park Details']
                            ) : '';
                        }
                    ],

                    [
                        'label' => 'Operator',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset(GeneralModel::safariparkoperatoroption()[$model->operator_id]) ? GeneralModel::safariparkoperatoroption()[$model->operator_id]  : '';
                        }
                    ],
                    'full_name',
                    'phone_no',
                    'email',
                    'safaris',
                    'travelers',
                    'created_at:dateTime:Request at',
                    // 'updated_at:dateTime:Last Updated at',
                    // [
                    //     'label' => 'Status',
                    //     'contentOptions' => ['style' => 'width: 10%; text-align: center;'],
                    //     'format' => 'raw',
                    //     'value' => function ($model) {
                    //         return $model->newstatuslabel;
                    //     }
                    // ],
                    // [
                    //     'class' => 'yii\grid\ActionColumn',
                    //     'header' => "Actions",
                    //     'contentOptions' => ['style' => 'width: 5%; text-align: center;'],
                    //     'template' => '&nbsp;{delete}',
                    //     'buttons' => [
                    //         // 'view' => function ($url, $model) {
                    //         //     return  Html::a('<img src="' . $this->params['baseurl'] . '/img/view.png" alt="" width="25" height="25">
                    //         //     ', ['/park/operator-quote/view', 'id' => $model->id], [
                    //         //         'class' => 'btn p-0 change-menuicon',
                    //         //         'title' => 'View',

                    //         //     ]);
                    //         // },

                    //         'delete' => function ($url, $model) {
                    //             return  Html::a('<img src="' . $this->params['baseurl'] . '/img/delete.png" alt="" width="25" height="25">', ['delete', 'id' => $model->id], [
                    //                 'class' => 'btn p-0 change-menuicon',
                    //                 'title' => 'Delete',
                    //                 'data' => [
                    //                     'confirm' => 'Are you sure you want to delete  ' . $model->full_name . '?',
                    //                     'method' => 'post',
                    //                 ],
                    //             ]);
                    //         },
                    //     ]
                    // ],
                ],
            ]); ?>
        </div>
    </div>
</div>