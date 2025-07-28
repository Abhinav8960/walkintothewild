<?php


use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\grid\GridView;
use yii\helpers\Url;

?>
<div class="commentCount mb-4">
    <h6> Comments</h6>
</div>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'label' => 'User',
                        'contentOptions' => ['style' => 'width: 20%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            if ($user = $model->user) {
                                return Html::img($user->avatar != '' ? $user->avatar : '/img/dpmain.png', ['class' => "rounded profile-picture", 'style' => "width:28px;"]) . ' ' . $user->name;
                            }
                            return $model->user_id;
                        }
                    ],
                    'comment',
                    [
                        'label' => 'Replies',
                        'contentOptions' => ['style' => 'width: 5%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->replies) ? count($model->replies) : '0';
                        }
                    ],
                    [
                        'label' => 'Flags',
                        'contentOptions' => ['style' => 'width: 5%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->reports) ? count($model->reports) : '0';
                        }
                    ],
                    // 'statuslabel:raw',
                    'created_at:dateTime:Created at',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => "Actions",
                        'contentOptions' => ['style' => 'width: 10%; text-align: center;'],
                        'template' => '{replies}&nbsp;&nbsp;{flag}',
                        'buttons' => [
                            'replies' => function ($url, $model) {
                                return Html::button('<img src="' . $this->params['baseurl'] . '/img/view.png" alt="" width="25" height="25">', [
                                    'value' => Url::toRoute(['replyview', 'id' => $model->id]),
                                    'class' => 'btn btn-warning choose-option mb-2',
                                    'title' => 'Replies'
                                ]);
                            },

                            'flag' => function ($url, $model) {
                                return Html::button('<img src="' . $this->params['baseurl'] . '/img/view.png" alt="" width="25" height="25">', [
                                    'value' => Url::toRoute(['flagview', 'id' => $model->id]),
                                    'class' => 'btn btn-warning flag-option mb-2',
                                    'title' => 'Flag'
                                ]);
                            },
                        ]
                    ],
                    [
                        'header' => 'Delete',
                        'contentOptions' => ['style' => 'width: 5%; text-align: center;'],
                        'value' => function ($model) {
                            return    Html::a('<i class="fa fa-trash"></i>', ['deletecomment', 'id' => $model->id], [
                                'style' => 'color: white !important; text-decoration:none;',
                                'title' => 'Delete Comment',
                                'class' => 'btn btn-danger',
                                'data-method' => 'POST',
                                'data-confirm' => 'Are you Sure you want to delete this Comment?',
                                'data-pjax' => "0"
                            ]);
                        },
                        'format' => 'raw'
                    ]
                ]
            ]); ?>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAction" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header flageHeader">
                <h6 class="modal-title fs-5" id="exampleModalLabel">
                    Replies
                </h6>
            </div>

            <div class="modal-body modal_form">
                <div id='modalContent'></div>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="modalflagAction" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header flageHeader">
                <h6 class="modal-title fs-5" id="exampleModalLabel">
                    Flags
                </h6>
            </div>

            <div class="modal-body modal_form">
                <div id='modalflagContent'></div>
            </div>

        </div>
    </div>
</div>
<?php
$script = <<< JS


    $('.choose-option').on('click', function () {
        $('#modalAction').modal('show')
		.find('#modalContent')
		.load($(this).attr('value'));
	});

JS;
$this->registerJs($script);
?>
<?php
$script = <<< JS


    $('.flag-option').on('click', function () {
        $('#modalflagAction').modal('show')
		.find('#modalflagContent')
		.load($(this).attr('value'));
	});

JS;
$this->registerJs($script);
?>