<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\master\office\MasterDepartmentSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */


$this->title = 'TERMS & CONDITIONS';
$this->params['breadcrumbs_home_url'] = '/cms/termscondition';
$this->params['breadcrumbs'][] =  ['label' => 'CMS', 'url' => '#'];
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
$this->params['buttons'][] = Html::a('+ Create', ['create'], ['class' => 'btn btn-orange ', 'title' => 'Create']);


?>
<div class="card">

    <div class="card-body">
        <?php //echo $this->render('_search', ['model' => $searchModel]); 
        ?>
        <div id="w1-button" class="mb-3"></div>
        <h6>List of TERMS & CONDITIONS</h6>
        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'contentOptions' => ['style' => 'width: 5%;'],
                    ],
                    [
                        'label' => 'Type',
                        'contentOptions' => ['style' => 'width: 15%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            // return $model->type;
                            return isset($model->termsconditiontype) ? $model->termsconditiontype->title : '';
                        }
                    ],

                    [
                        'label' => 'Module Description',
                        'contentOptions' => ['style' => 'width: 65%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->description) ? $model->description : '';
                        }
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => "Actions",
                        'contentOptions' => ['style' => 'width: 15%;'],
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return  Html::a('<img src="' . $this->params['baseurl'] . '/img/view.png" alt="View" width="25" height="25">
                                ', ['view', 'id' => $model->id], [
                                    'class' => 'btn p-0 change-menuicon',
                                    'type' => 'View',
                                ]);
                            },
                            'update' => function ($url, $model) {
                                return  Html::a('<img src="' . $this->params['baseurl'] . '/img/update.png" alt="" width="25" height="25">
                                ', ['update', 'id' => $model->id], [
                                    'class' => 'btn p-0 change-menuicon',
                                    'type' => 'Update',
                                ]);
                            },
                        ]
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>