<?php

use api\models\leads\LeadPartners;
use common\models\GeneralModel;
use common\models\operator\SafariOperatorFaq;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\business\assets\PartnerAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$this->title = 'Faqs';
$this->params['title'] = $this->title;

$this->params['buttons'][] = Html::a('Create', ['create'], ['class' => 'button-created new create float-end mt-3', 'title' => 'Create']);
// $this->params['buttons'][] = Html::Button('Set Sequence', ['value' => '/faqs/default/setsequence', 'class' => 'btn  popupButton btn-secondary float-end mt-3 me-2', 'title' => 'Set Sequence']);
?>



<?php echo $this->render('_search', ['model' => $searchModel, 'safari_operator' => $safari_operator]); ?>

<div class="table-wrapper">
    <div class="table-responsive">
        <div class="min-width-table">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'layout' => "{items}\n<div class='row align-items-center mt-3'>
                            <div class='col-md-4 text-start mb-2'>{summary}</div>
                            <div class='col-md-4 text-center mb-2'>{pager}</div>
                            <div class='col-md-4'></div>
                        </div>",
                'tableOptions' => ['class' => 'table tablecustoms table-striped align-middle w-100'],
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'headerOptions' => ['style' => 'width: 5%;'],
                    ],
                    [
                        'label' => 'Questions',
                        'contentOptions' => ['style' => 'width: 20%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->question) ? $model->question : '' ;
                        }
                    ],

                    [
                        'label' => 'Answers',
                        'contentOptions' => ['style' => 'width: 20%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->answer) ? $model->answer : '' ;
                        }
                    ],

                    [
                        'label' => 'Park',
                        'contentOptions' => ['style' => 'width: 20%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->park) ? $model->park->title : '' ;
                        }
                    ],

                    [
                        'label' => 'Status',
                        'contentOptions' => ['style' => 'width: 20%; text-align: left;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->newstatuslabel;
                        }
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => "Actions",
                        'headerOptions' => ['style' => 'width: 10%;'],
                        'contentOptions' => ['style' => 'width: 10%; text-align: left;'],
                        'template' => '{update}',
                        'buttons' => [

                            'update' => function ($url, $model) {
                                {
                                    return  Html::a('<img src="' . $this->params['baseurl'] . '/images/Edit.svg" alt="" width="25" height="25">
                                ', ['/faqs/default/update', 'id' => $model->id], [
                                        'class' => 'btn p-0 change-menuicon',
                                        'title' => 'View',

                                    ]);
                                }
                                return Html::tag('span', '', [
                                    'style' => 'display:inline-block;width:25px;height:25px;'
                                ]);
                            },
                            // 'view' => function ($url, $model) {
                            //     return  Html::a('<i class="mdi mdi-eye"></i>', ['/faqs/default/view', 'id' => $model->id], [
                            //         'class' => 'btn p-0 change-menuicon',
                            //         'title' => 'View',
                            //     ]);
                            // },
                        ]
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>