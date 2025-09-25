<?php

use common\models\compliancedocuments\ComplianceDocumentsVersion;
use yii\helpers\Html;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\compliancedcuments\ComplianceDocumentsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Compliance Documents Versions';
$this->params['breadcrumbs_home_url'] = '/';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;

?>
<div class="card">

    <div class="card-body">
        <!-- <?php echo $this->render('_search', ['model' => $searchModel]); ?> -->
        <div id="w1-button" class="mb-3"></div>

        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'label' => 'Type',
                        // 'contentOptions' => ['style' => 'width: 30%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->type
                                ? ComplianceDocumentsVersion::compliancedocumenttype($model->type)
                                : ' ';
                        },
                    ],
                    [
                        'attribute' => 'Effective Date',
                        'format' => 'html',
                        'enableSorting' => true,
                        // 'contentOptions' => ['style' => 'width:10%; text-align: center;'],
                        'value' => function ($model) {
                            if(isset($model->effective_date)){
                            return \Yii::$app->formatter->asDatetime($model->effective_date, "php:d-m-Y");
                            }else{
                                return "";
                            }
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
                        'contentOptions' => ['style' => 'width: 10%; text-align: center;'],
                        'template' => '{view}',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return  Html::a('<img src="' . $this->params['baseurl'] . '/img/view.png" alt="" width="25" height="25">
                                ', ['version-view', 'id' => $model->id], [
                                    'class' => 'btn p-0 change-menuicon',
                                    'title' => 'Version-View',

                                ]);
                            },

                        ]
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>