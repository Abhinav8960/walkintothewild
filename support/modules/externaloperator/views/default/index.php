<?php

use common\models\GeneralModel;
use yii\helpers\Html;

use yii\widgets\Pjax;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = 'External Operator List';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
$this->params['buttons'][] = Html::a('Create', ['create'], ['class' => 'button-created new create float-end mt-3', 'title' => 'Create']);
?>
<?php Pjax::begin([
    'id' => 'grid-data',
    'enablePushState' => false,
    'enableReplaceState' => false,
    'timeout' => false,
]); ?>

<?php echo $this->render('_search', ['model' => $searchModel]); ?>

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
                        // 'contentOptions' => ['style' => 'width: 10%;'],
                    ],
                    [
                        'label' => 'Park Name',
                        'contentOptions' => ['style' => 'width: 40%; text-align: center;'],
                        'headerOptions' => ['style' => 'width: 10%; text-align: center;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            $park_names = [];
                            foreach ($model->parkList as $parkList) {
                                $park_names[] = $parkList->park->title;
                            }
                            return implode('<br>', $park_names);
                        }
                    ],
                    
                    [
                        'label' => 'Partner Name',
                        'headerOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->operator_name) ? $model->operator_name : '';
                        },
                    ],
                    [
                        'label' => 'Phone Number',
                        'headerOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->phone_no) ? $model->phone_no : '';
                        }
                    ],
                    [
                        'label' => 'Email',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->email) ? $model->email : '';
                        }
                    ],
                    [
                        'label' => 'Owner Name',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->owner_name) ? $model->owner_name : '';
                        }
                    ],
                    [
                        'label' => 'Owner Email',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->owner_email) ? $model->owner_email : '';
                        }
                    ],
                    [
                        'label' => 'Owner Phone Number',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->owner_phone_no) ? $model->owner_phone_no : '';
                        }
                    ],

                    [
                        'label' => 'Status',
                        'contentOptions' => ['style' => 'width: 15%; text-align: left;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->newstatuslabel;
                        }
                    ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => "Actions",
                        'contentOptions' => ['style' => 'width: 25%; text-align: left;'],
                        'template' => '{edit}&nbsp;{delete}&nbsp;{call_done}&nbsp;{email_send}&nbsp;{comment}',
                        'buttons' => [
                            // 'view' => function ($url, $model) {
                            //     return Html::a(
                            //         '<i class="mdi mdi-eye"></i>',
                            //         ['view', 'id' => $model->id],
                            //         [
                            //             'class' => 'action-icon',
                            //             'title' => 'View',
                            //         ]
                            //     );
                            // },

                            'edit' => function ($url, $model) {
                                return Html::a(
                                    '<i class="mdi mdi-pencil"></i>',
                                    ['update', 'id' => $model->id],
                                    [
                                        'class' => 'btn p-0 change-menuicon',
                                        'title' => 'Edit',
                                    ]
                                );
                            },

                            'delete' => function ($url, $model) {
                                return Html::a('<i class="mdi mdi-delete"></i>',
                                       ['delete', 'id' => $model->id],
                                       [
                                        'class' => 'btn p-0 change-menuicon',
                                        'title' => 'Delete',
                                    ]
                                );
                            },

                            'call_done' => function ($url, $model) {
                                return Html::button('<i class="mdi mdi-phone"></i>',
                                    [
                                        'value' =>  Url::toRoute(['call-done', 'id' => $model->id]),
                                        'class' => 'btn p-0 change-menuicon call-popup',
                                        'title' => 'Call Done',
                                    ]
                                );
                            },

                            'email_send' => function ($url, $model) {
                                return Html::button('<i class="mdi mdi-email"></i>',
                                    [
                                        'value' =>  Url::toRoute(['email-send', 'id' => $model->id]),
                                        'class' => 'btn p-0 change-menuicon email-popup',
                                        'title' => 'Email Send',
                                    ]
                                );
                            },

                            'comment' => function ($url, $model) {
                                return Html::button('<i class="mdi mdi-comment"></i>',
                                    [
                                        'value' =>  Url::toRoute(['comment', 'id' => $model->id]),
                                        'class' => 'btn p-0 change-menuicon comment-popup',
                                        'title' => 'Comment',
                                    ]
                                );
                            },

                        ]
                    ],

                ],
            ]); ?>
        </div>
    </div>
</div>

<?php Pjax::end(); ?>

<div class="modal fade" id="callAction" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header popHeader">
                <h6 class="modal-title fs-5" id="exampleModalLabel">
                    Call Status
                </h6>
            </div>

            <div class="modal-body modal_form">
                <div id='callcheck'></div>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="emailAction" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header popHeader">
                <h6 class="modal-title fs-5" id="exampleModalLabel">
                    Email Status
                </h6>
            </div>

            <div class="modal-body modal_form">
                <div id='emailcheck'></div>
            </div>

        </div>
    </div>
</div>


<div class="modal fade" id="commentAction" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header popHeader">
                <h6 class="modal-title fs-5" id="exampleModalLabel">
                    Comment
                </h6>
            </div>

            <div class="modal-body modal_form">
                <div id='commentcheck'></div>
            </div>

        </div>
    </div>
</div>


<?php
$script = <<< JS

    $('.call-popup').on('click', function () {
        $('#callAction').modal('show')
		.find('#callcheck')
		.load($(this).attr('value'));
	});

    $('.email-popup').on('click', function () {
        $('#emailAction').modal('show')
		.find('#emailcheck')
		.load($(this).attr('value'));
	});

    $('.comment-popup').on('click', function () {
        $('#commentAction').modal('show')
		.find('#commentcheck')
		.load($(this).attr('value'));
	});


JS;
$this->registerJs($script);
?>