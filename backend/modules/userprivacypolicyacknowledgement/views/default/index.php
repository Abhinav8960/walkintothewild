<?php

use common\models\GeneralModel;
use yii\helpers\Html;

use yii\widgets\Pjax;
use yii\grid\GridView;

$this->title = 'User Privacy Policy Acknowledgemnt';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
?>

<?= $this->render('_search', ['model' => $searchModel]) ?>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'contentOptions' => ['style' => 'width: 5%;'],
                    ],
                    [
                        'attribute' => 'user',
                        'contentOptions' => ['style' => 'width: 20%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->user->name;

                        },
                    ],
                    [
                        'label' => 'email',
                        'contentOptions' => ['style' => 'width: 20%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->user->email;
                        }
                    ],
                    [
                        'label' => 'uuid',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->uuid;
                        }
                    ],
                    [
                        'label' => 'Document',
                        'contentOptions' => ['style' => 'width: 20%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            if ($model->document->type) {
                                return isset(GeneralModel::complianceDocumentsTitleoption()[$model->document->type]) ? GeneralModel::complianceDocumentsTitleoption()[$model->document->type] : '';
                            }
                        }
                    ],    
                    [
                        'label' => 'Document Version',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->document_version;
                        }
                    ],
                    [
                        'label' => 'Acknowledge DateTime',
                        'contentOptions' => ['style' => 'width: 20%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return \Yii::$app->formatter->asDatetime($model->created_at);
                        }
                    ],

                    // [
                    //     'header' => 'Action',
                    //     'value' => function ($model) {
                    //         if ($model->is_approved != 1) {
                    //             return Html::a('<i class="fa fa-toggle-on"></i>', ['approved', 'id' => $model->id], [
                    //                 'class' => 'btn btn-xs btn-danger',
                    //                 'data-method' => 'post',
                    //                 'data-confirm' => 'Are you sure to approved this Business?',
                    //                 'title' => 'Approved Business',
                    //                 'data-bs-toggle' => "tooltip"
                    //             ]);
                    //         }
                    //         return '';
                    //     },
                    //     'format' => 'raw',
                    //     'headerOptions' => ['style' => 'width:5%;'],
                    //     'contentOptions' => ['style' => 'width: 5%; text-align: center;'],
                    // ],
                ],
            ]); ?>
        </div>
    </div>
</div>