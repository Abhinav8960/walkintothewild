<?php

use common\models\GeneralModel;
use Google\Service\VMwareEngine\Upgrade;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\compliancedcuments\ComplianceDocumentsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Compliance Documents';
$this->params['breadcrumbs_home_url'] = '/';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
$this->params['buttons'][] = Html::a('+ Create', ['create'], ['class' => 'btn btn-orange ', 'title' => 'Create']);


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
                        'contentOptions' => ['style' => 'width: 30%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->title;
                        }
                    ],
                    [
                        'label' => 'Policy For',
                        'contentOptions' => ['style' => 'width: 20%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->policy_for;
                        }
                    ],
                    [
                        'attribute' => 'Effective From',
                        'format' => 'html',
                        'enableSorting' => true,
                        'contentOptions' => ['style' => 'width:20%;text-align: center;'],
                        'value' => function ($model) {
                            return \Yii::$app->formatter->asDatetime($model->effective_from, "php:d-m-Y");
                        }
                    ],
                    [
                        'label' => 'Version',
                        'contentOptions' => ['style' => 'width: 10%; text-align: center;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            $str = '<span class="badge badge-success fs-6">' . $model->version . '</span>';
                            return $str;
                        }
                    ],
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
                        'template' => '{update}&nbsp;&nbsp;{delete}&nbsp{upgrade}',
                        'buttons' => [
                            'update' => function ($url, $model) {
                                return  Html::a('<img src="' . $this->params['baseurl'] . '/img/update.png" alt="" width="25" height="25">
                                ', ['update', 'id' => $model->id], [
                                    'class' => 'btn p-0 change-menuicon',
                                    'title' => 'Update',

                                ]);
                            },

                            'delete' => function ($url, $model) {
                                return  Html::a('<img src="' . $this->params['baseurl'] . '/img/delete.png" alt="" width="25" height="25">', ['delete', 'id' => $model->id], [
                                    'class' => 'btn p-0 change-menuicon',
                                    'title' => 'Delete',
                                    'data' => [
                                        'confirm' => 'Are you sure you want to delete ?',
                                        'method' => 'post',
                                    ],
                                ]);
                            },
                         
                            'upgrade' => function ($url, $model) {
                                return Html::a('Upgrade', 
                                    ['version-upgrade', 'id' => $model->id], [
                                        'class' => 'btn btn-sm btn-warning',
                                        'title' => 'Upgrade Version',
                                    ]);
                            },
                        ]
                        
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>