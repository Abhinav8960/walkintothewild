<?php


/* @var $this yii\web\View */
/* @var $model common\models\corporate\Corporate */

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Sightings Comment';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;

?>


<div class="card">

    <div class="card-body">
        <div id="w1-button" class="mb-3"></div>
        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'contentOptions' => ['style' => 'width: 5%;'],
                    ],
                    [
                        'label' => 'Comment',
                        'contentOptions' => ['style' => 'width: 15%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->comment;
                        }
                    ],
                    [
                        'label' => 'Date',
                        'contentOptions' => ['style' => 'width: 15%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->dateTime;
                        }
                    ],
                    [
                        'label' => 'Creator Name',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->user->name;
                        }
                    ],

                    [
                        'label' => 'Reply Count',
                        'contentOptions' => ['style' => 'width: 10%; text-align: center;'],
                        'headerOptions' => ['style' => 'width: 10%; text-align: center;'],

                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->replies_count;
                        }
                    ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => "Actions",
                        'contentOptions' => ['style' => 'width:50px; text-align:center;'],
                        'headerOptions' => ['style' => 'width:50px; text-align:center;'],
                        'template' => '{view}&nbsp{delete}&nbsp',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return Html::button('<img src="' . $this->params['baseurl'] . '/img/view.png" alt="" width="25" height="25">', [
                                    'value' => Url::toRoute(['reply-listing', 'parent_id' => $model->id]),
                                    'class' => 'btn btn-warning replies-list mb-2',
                                    'title' => 'View'
                                ]);
                            },
                            'delete' => function ($url, $model) {
                                return Html::a(
                                    Html::img($this->params['baseurl'] . '/img/delete.png', ['alt' => '', 'width' => 25, 'height' => 25]),
                                    [
                                        Url::toRoute(['comment-delete', 'id' => $model->id]),
                                    ],
                                    [
                                        'class' => 'btn p-0 change-menuicon',
                                        'title' => 'View',
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

<div class="modal fade" id="replyAction" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header flageHeader">
                <h6 class="modal-title fs-5" id="exampleModalLabel">
                    Replies
                </h6>
            </div>

            <div class="modal-body modal_form">
                <div id='replyContent'></div>
            </div>

        </div>
    </div>
</div>

<?php
$script = <<< JS

    $('.replies-list').on('click', function () {
        $('#replyAction').modal('show')
		.find('#replyContent')
		.load($(this).attr('value'));
	});

JS;
$this->registerJs($script);
?>