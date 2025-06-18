<?php

use yii\helpers\Html;

use yii\widgets\Pjax;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = 'Posts';
$this->params['title'] = $this->title;
?>
<?php Pjax::begin([
    'id' => 'grid-data',
    'enablePushState' => false,
    'enableReplaceState' => false,
    'timeout' => false,
]); ?>

<div class="card">
    <div class="card-body">
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
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
                        'label' => 'Thumbnail',
                        'contentOptions' => ['style' => 'width: 10%; text-align: center;'],
                        'headerOptions' => ['style' => 'width: 10%; text-align: center;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            if ($model->filepath) {
                                return Html::tag('div', Html::img(Yii::$app->params['s3_endpoint'] .'/'. $model->filepath, [
                                    'alt' => 'Uploaded Image',
                                ]), ['style' => 'text-align: center;']);
                            }
                            return '';
                        }
                    ],
                    [
                        'label' => 'User Name',
                        'headerOptions' => ['style' => 'width: 15%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            $imageUrl = isset($model->user) ? $model->user->profile_display_image : $this->params['baseurl'] . '/img/NewBanner_big.png';
                            $name = isset($model->user) ? $model->user->name : '';
                            return '<img src="' . $imageUrl . '" alt="" style="max-height:30px;"> ' . Html::encode($name);
                        },
                    ],

                    [
                        'label' => 'Partner Name',
                        'headerOptions' => ['style' => 'width: 15%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            $imageUrl = isset($model->safarioperator->imagepath) ? $model->safarioperator->imagepath : '';
                            $name = isset($model->safarioperator) ? $model->safarioperator->business_name : '';
                            return '<img src="' . $imageUrl . '" alt="" style="max-height:30px;"> ' . Html::encode($name);
                        },
                    ],
                    [
                        'label' => 'Caption',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return mb_strimwidth($model->caption, 0, 19, "...");
                        }
                    ],
                    [
                        'label' => 'Comments',
                        'contentOptions' => ['style' => 'text-align: right;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            // return Html::button($model->comments_count, [
                            //     'value' => Url::toRoute(['comment-listing', 'id' => $model->id]),
                            //     'class' => 'comment-popup btn btn-info',
                            // ]);
                            return $model->comment_count;
                        }
                    ],
                    [
                        'label' => 'Likes',
                        'contentOptions' => ['style' => 'text-align: right;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->like_count;
                        }
                    ],
                    [
                        'label' => 'Last Updated',
                        'contentOptions' => ['style' => 'width: 10%; text-align: center;'],
                        'headerOptions' => ['style' => 'width: 10%; text-align: center;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return date("F j, Y, g:i a", $model->updated_at);
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
                        'contentOptions' => ['style' => 'width:15%; text-align:left;'],
                        'template' => '{view}&nbsp{delete}&nbsp{suspend}',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                if ($model->file) {
                                    return Html::a(
                                        Html::img($this->params['baseurl'] . '/img/view.png', ['alt' => '', 'width' => 25, 'height' => 25]),
                                        [
                                            Url::toRoute(['/posts/default/view', 'id' => $model->id])
                                        ],
                                        [
                                            'class' => 'btn p-0 change-menuicon',
                                            'title' => 'View',
                                        ]
                                    );
                                }
                                return '';
                            },
                            // 'delete' => function ($url, $model) {
                            //     return Html::button(
                            //         Html::img($this->params['baseurl'] . '/img/delete.png', ['alt' => '', 'width' => 25, 'height' => 25]),
                            //         [
                            //             'value' => Url::toRoute(['post-delete', 'id' => $model->id]),
                            //             'class' => 'btn p-0 change-menuicon delete-popup',
                            //             'title' => 'View',
                            //         ]
                            //     );
                            // },
                            'suspend' => function ($url, $model) {
                                return \backend\widgets\SuspendActiveButton::widget(['model' => $model, 'suspend_button_title' => 'Inactive', 'active_title' => 'Sighting', 'suspend_title' => 'Sighting']);
                            },
                        ]
                    ],

                ],
            ]); ?>
        </div>
    </div>
</div>

<?php Pjax::end(); ?>


<!-- <div class="modal fade" id="modalAction" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header popHeader">
                <h6 class="modal-title fs-5" id="exampleModalLabel">
                    Details
                </h6>
            </div>

            <div class="modal-body modal_form">
                <div id='modalContent'></div>
            </div>

        </div>
    </div>
</div> -->


<div class="modal fade" id="commentAction" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header popHeader">
                <h6 class="modal-title fs-5" id="exampleModalLabel">
                    Comments
                </h6>
            </div>

            <div class="modal-body modal_form">
                <div id='commentContent'></div>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="deleteAction" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header popHeader">
                <h6 class="modal-title fs-5" id="exampleModalLabel">
                    Delete
                </h6>
            </div>

            <div class="modal-body modal_form">
                <div id='deleteContent'></div>
            </div>

        </div>
    </div>
</div>



<?php
$script = <<< JS

    // $('.post-popup').on('click', function () {
    //     $('#modalAction').modal('show')
	// 	.find('#modalContent')
	// 	.load($(this).attr('value'));
	// });

    $('.comment-popup').on('click', function () {
        $('#commentAction').modal('show')
		.find('#commentContent')
		.load($(this).attr('value'));
	});

    $('.delete-popup').on('click', function () {
        $('#deleteAction').modal('show')
		.find('#deleteContent')
		.load($(this).attr('value'));
	});

JS;
$this->registerJs($script);
?>