<?php

use common\models\cms\contentmanagement\ContentManagement;
use common\models\GeneralModel;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\master\office\MasterDepartmentSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Content Management';
$this->params['breadcrumbs_home_url'] = '/cms/content-management';
$this->params['breadcrumbs'][] =  ['label' => 'CMS', 'url' => '#'];
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
// $this->params['buttons'][] = Html::a('+ Create', ['create'], ['class' => 'btn btn-orange ', 'title' => 'Create']);


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
                        'contentOptions' => ['style' => 'max-width: 20px !important; width: 700px !important; word-wrap: break-word; text-align: center; padding: 0; margin: 0;'],
                    ],
                    [
                        'attribute' => 'name',
                        'contentOptions' => ['style' => 'max-width: 900px !important; width: 700px !important; word-wrap: break-word; text-align: left; padding: 0; margin: 0;'],
                    ],
                    // [
                    //     'label' => 'content',
                    //     'format' => 'raw',
                    //     'value' => function ($model) {
                    //         return isset($model->content) ? $model->content : '';
                    //     },
                    //     'contentOptions' => ['style' => 'max-width: 700px !important; width: 700px !important; word-wrap: break-word; text-align: left; padding: 0; margin: 0;'],
                    // ],
                    [
                        'label' => 'Type',
                        'format' => 'raw',
                        'value' => function ($model) {
                            $typeLabels = ContentManagement::getTypeLabels(); // Adjust the model namespace and class name as needed
                            return isset($typeLabels[$model->type]) ? $typeLabels[$model->type] : $model->type;
                        },
                        'contentOptions' => ['style' => 'max-width: 300px !important; width: 700px !important; word-wrap: break-word; text-align: left; padding: 0; margin: 0;'],
                    ],
                    [
                        'label' => 'remark',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->remark) ? $model->remark : '';
                        },
                        'contentOptions' => ['style' => 'max-width: 500px !important; width: 700px !important; word-wrap: break-word; text-align: left; padding: 0; margin: 0;'],
                    ],
                    
                    // [
                    //     'label' => 'Status',
                    //     'format' => 'raw',
                    //     'value' => function ($model) {
                    //         return $model->statuslabel;
                    //     },
                    //     'contentOptions' => ['style' => 'max-width: 700px !important; width: 700px !important; word-wrap: break-word; text-align: left; padding: 0; margin: 0;'],
                    // ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => "Actions",
                        'contentOptions' => ['style' => 'max-width: 200px !important; width: 700px !important; word-wrap: break-word; text-align: left; padding: 0; margin: 0;'],
                        'template' => '{update}&nbsp;&nbsp;{delete}',
                        'buttons' => [
                            'update' => function ($url, $model) {
                                return  Html::a('<img src="' . $this->params['baseurl'] . '/img/update.png" alt="" width="25" height="25">
                        ', ['update', 'id' => $model->id], [
                                    'class' => 'btn p-0 change-menuicon',
                                    'title' => 'Update',

                                ]);
                            },

                            // 'delete' => function ($url, $model) {
                            //     return  Html::a('<img src="' . $this->params['baseurl'] . '/img/delete.png" alt="" width="25" height="25">', ['delete', 'id' => $model->id], [
                            //         'class' => 'btn p-0 change-menuicon',
                            //         'title' => 'Delete',
                            //         'data' => [
                            //             'confirm' => 'Are you sure you want to delete  ' . $model->name . '?',
                            //             'method' => 'post',
                            //         ],
                            //     ]);
                            // },
                        ]
                    ],
                ],
            ]); ?>
        </div>

    </div>
</div>