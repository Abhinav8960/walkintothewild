<?php

use common\models\compliancedocuments\ComplianceDocuments;
use common\models\compliancedocuments\ComplianceDocumentsVersion;
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

$dropdown = GeneralModel::compliancedropdown();
if (!empty($dropdown)) {
    $this->params['buttons'][] = Html::a('+ Create',['create'],['class' => 'btn btn-orange', 'title' => 'Create']);
} 

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
                        'contentOptions' => ['style' => 'width: 40%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->labeltype;
                        },
                    ],
                    [
                        'attribute' => 'Effective Date',
                        'contentOptions' => ['style' => 'width: 20%;'],
                        'format' => 'html',
                        'enableSorting' => true,
                        'value' => function ($model) {
                            if(isset($model->effective_date)){
                            return \Yii::$app->formatter->asDatetime($model->effective_date, "php:d-m-Y");
                            }else{
                                return "";
                            }
                        }
                    ],
                    [
                        'label' => 'Status',
                        'contentOptions' => ['style' => 'width: 20%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->statuslabel;
                        }
                    ],
                    [
                        'label' => 'Version',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->version;
                        }
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => "Actions",
                        'contentOptions' => ['style' => 'width: 10%; text-align: center;'],
                        'template' => '{view}&nbsp;{update}&nbsp;{versionview}',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return  Html::a('<img src="' . $this->params['baseurl'] . '/img/view.png" alt="" width="25" height="25">
                                ', ['view', 'id' => $model->id], [
                                    'class' => 'btn p-0 change-menuicon',
                                    'title' => 'View',

                                ]);
                            },

                            'update' => function ($url, $model) {
                                if ($model->status == ComplianceDocuments::STATUS_UNPUBLISHED) {
                                    return  Html::a('<img src="' . $this->params['baseurl'] . '/img/update.png" alt="" width="25" height="25">
                                ', ['update', 'id' => $model->id], [
                                        'class' => 'btn p-0 change-menuicon',
                                        'title' => 'Update',

                                    ]);
                                }
                                
                                // else{
                                //     return  Html::a('<img src="' . $this->params['baseurl'] . '/img/update.png" alt="" width="25" height="25">
                                // ', ['edit', 'id' => $model->id], [
                                //         'class' => 'btn p-0 change-menuicon',
                                //         'title' => 'Update',

                                //     ]);
                                // }
                            },
                        ]
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>