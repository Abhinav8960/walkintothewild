<?php

use api\models\leads\LeadPartners;
use common\models\GeneralModel;
use common\models\leads\form\LeadReminderForm;
use common\models\leads\LeadPartnerReminders;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\business\assets\PartnerAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$this->title = 'Leads';
// $this->params['title'] = $this->title;
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
                        'headerOptions' => ['style' => 'width: 1%;'],
                    ],
                    [
                        'label' => 'User Name',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            if ($user = $model->user) {
                                $name = $user->name ?? '';
                                $imageUrl = $user->profile_display_image ?:  $this->params['baseurl'] . '/images/dpmain.png';
                                return
                                    Html::img($imageUrl, [
                                        'class' => "rounded profile-picture",
                                        'style' => "width:28px;"
                                    ]) . ' ' . Html::encode($name);
                            }
                            return '';
                        }
                    ],
                    [
                        'label' => 'Source',
                        'contentOptions' => ['style' => 'width: 1%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->sourceLabelWithBadge;
                        }
                    ],

                    [
                        'label' => 'Travel Interest',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->displayLabel;
                        }
                    ],

                    [
                        'label' => 'Safaris',
                        'contentOptions' => ['style' => 'width: 1%; text-align: left;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return !empty($model->safaris) ? $model->safaris : '';
                        }
                    ],
                    [
                        'label' => 'Travelers',
                        'contentOptions' => ['style' => 'width: 1%; text-align: left;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return !empty($model->travelers) ? $model->travelers : '';
                        }
                    ],

                    [
                        'label' => 'Accomodation',
                        'contentOptions' => ['style' => 'width: 1%; text-align: left;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return !empty($model->staycatgory) ? $model->staycatgory->title : '';
                        }
                    ],
                    [
                        'label' => 'Travel Date',
                        'contentOptions' => ['style' => 'width: 8%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            $str =  date('d M, Y', strtotime($model->from_date));
                            if (!empty($model->to_date)) {
                                $str .=  '- ' . date('d M, Y', strtotime($model->to_date));
                            }
                            return $str;
                        }
                    ],

                    [
                        'label' => 'Lead Received',
                        'contentOptions' => ['style' => 'width: 8%; text-align: left;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return date('d M, Y h:i A', $model->created_at);
                        }
                    ],

                    [
                        'label' => 'Quotation Count',
                        'headerOptions' => ['style' => 'width: 15%;'],
                        'format' => 'raw',
                        'value' => function ($model) use ($safari_operator) {
                            $count = LeadPartners::quotationCount($model->id, $safari_operator->id);
                            return $count;
                        }
                    ],

                    [
                        'label' => 'Chat Started',
                        'headerOptions' => ['style' => 'width: 15%;'],
                        'format' => 'raw',
                        'value' => function ($model) use ($safari_operator) {
                            return LeadPartners::chatStarted($model->id, $safari_operator->id);
                        }
                    ],
                    [
                        'label' => 'Lead Category',
                        'headerOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) use ($safari_operator) {
                            return LeadPartnerReminders::getLeadcategory($model->id, $safari_operator->id);
                        }
                    ],
                    
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => "Actions",
                        'contentOptions' => ['style' => 'width: 10%; text-align: left;'],
                        'template' => '{view}',
                        'buttons' => [

                            'view' => function ($url, $model) {
                                return  Html::a('<i class="mdi mdi-eye"></i>', ['/leads/default/view', 'id' => $model->id], [
                                    'class' => 'action-icon',
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