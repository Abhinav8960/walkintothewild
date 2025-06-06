<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = 'Safari Tour Operator';
// $this->params['breadcrumbs_home_url'] = '/registration/safari-operator-tour';
$this->params['breadcrumbs'][] =  ['label' => 'Operator', 'url' => '#'];
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
                        'attribute' => 'business_name',
                        'format' => 'raw',
                        'value' => function ($model) {
                            // return Html::a($model->business_name, ['view', 'id' => $model->id], [
                            //     'style' => 'color: black !important;',
                            //     'title' => 'View',
                            // ]);
                            return $model->business_name;
                        },
                        'contentOptions' => ['style' => 'width: 20%; text-align: left;'],
                    ],
                    [
                        'label' => 'Registered Name',
                        'contentOptions' => ['style' => 'width: 15%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->register_comapany_name;
                        }
                    ],
                    [
                        'label' => 'Phone Number',
                        'contentOptions' => ['style' => 'width: 15%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->phone_no;
                        }
                    ],
                    [
                        'label' => 'Category',
                        'contentOptions' => ['style' => 'width: 20%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            if ($model->category_id) {
                                return isset(GeneralModel::operatorcategory()[$model->category_id]) ? GeneralModel::operatorcategory()[$model->category_id] : '';
                            }
                        }
                    ],
                    [
                        'label' => 'Budget Segment',
                        'contentOptions' => ['style' => 'width: 15%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            $budget = [];
                            if ($model->is_offer_premium_budget == 1) {
                                $budget[] = "Premium";
                            }
                            if ($model->is_offer_standard_budget == 1) {
                                $budget[] = "Standard";
                            }
                            if ($model->is_offer_economical_budget == 1) {
                                $budget[] = "Economical";
                            }
                            return implode(', ', $budget);
                        }
                    ],
                    // [
                    //     'label' => 'Approved Status',
                    //     'contentOptions' => ['style' => 'width: 5%;'],
                    //     'format' => 'raw',
                    //     'value' => function ($model) {
                    //         if ($model->is_approved) {
                    //             return isset(GeneralModel::yesnooption()[$model->is_approved]) ? GeneralModel::yesnooption()[$model->is_approved] : '';
                    //         } else {
                    //             return 'No';
                    //         }
                    //     }
                    // ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => "Actions",
                        'contentOptions' => ['style' => 'width: 15%;'],
                        'template' => '{view}&nbsp{temporary}&nbsp{checkin}&nbsp{update}&nbsp{suspend}',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return  Html::a('<img src="' . $this->params['baseurl'] . '/img/view.png" alt="" width="25" height="25">
                                ', ['view', 'id' => $model->id], [
                                    'class' => 'btn p-0 change-menuicon',
                                    'title' => 'View',

                                ]);
                            },
                            // 'checkin' => function ($url, $model) {
                            //     $partnerUrl = Yii::$app->urlManagerPartner->createAbsoluteUrl(['/check-in', 'username' => $model->user->username, 'google_source_id' => $model->user->google_source_id]);
                            //     return Html::a(
                            //         '<img src="' . $this->params['baseurl'] . '/img/login.png" alt="" width="25" height="25">',
                            //         $partnerUrl,
                            //         [
                            //             'class' => 'btn p-0 change-menuicon',
                            //             'title' => 'Update',
                            //         ]
                            //     );
                            // },
                            
                            'temporary' => function ($url, $model) {
                                if ($model->is_temporary_delete != 1) {
                                    return Html::a(
                                        '<img src="' . $this->params['baseurl'] . '/img/temp_delete.png" alt="" width="25" height="25">',
                                        ['temporary-delete', 'id' => $model->id],
                                        [
                                            'class' => 'btn p-0 change-menuicon',
                                            'title' => 'Temporary Delete',
                                            // 'target' => '_blank',
                                        ]
                                    );
                                }
                            },

                            'checkin' => function ($url, $model) {
                                if ($model->is_temporary_delete != 1) {
                                    return Html::a(
                                        '<img src="' . $this->params['baseurl'] . '/img/login.png" alt="" width="25" height="25">',
                                        Yii::$app->params['partner_url'] . '/check-in?username=' . $model->user->username . '&google_source_id=' . $model->user->google_source_id,
                                        [
                                            'class' => 'btn p-0 change-menuicon',
                                            'title' => 'Check-out',
                                            'target' => '_blank',
                                        ]
                                    );
                                }
                            },

                            // 'update' => function ($url, $model) {
                            //     if ($model->is_temporary_delete != 1) {
                            //         return Html::a(
                            //             '<img src="' . $this->params['baseurl'] . '/img/update.png" alt="" width="25" height="25">',
                            //             ['update', 'id' => $model->id],
                            //             [
                            //                 'class' => 'btn p-0 change-menuicon',
                            //                 'title' => 'Update',
                            //             ]
                            //         );
                            //     }
                            // },
                            // 'suspend' => function ($url, $model) {
                            //     if ($model->is_temporary_delete != 1) {
                            //         return \backend\widgets\SuspendActiveButton::widget(['model' => $model, 'active_title' => 'Safari Tour Operator', 'suspend_title' => 'Safari Tour Operator']);
                            //     }
                            // },

                        ]
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>