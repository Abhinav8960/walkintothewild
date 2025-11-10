<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

$webasset = $this->assetManager->getBundle('\support\assets\NovaAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$this->title = 'Posts';
$this->params['title'] = $this->title;
?>


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
                        'headerOptions' => ['style' => 'width: 1%;'],
                    ],
                    [
                        'label' => 'Thumbnail',
                        'contentOptions' => ['style' => 'width: 10%; text-align: center;'],
                        // 'headerOptions' => ['style' => 'width: 10%; text-align: center;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            if ($model->filepath) {
                                return Html::tag('div', Html::img(Yii::$app->params['s3_endpoint'] . '/' . $model->filepath, [
                                    'alt' => 'Uploaded Image',
                                ]), ['class' => 'thumb-wrapper','style' => 'text-align: center;']);
                            }
                            return '';
                        }
                    ],

                    [
                        'label' => 'User Name',
                        'contentOptions' => ['style' => 'width: 1%; text-align: center;'],
                        // 'headerOptions' => ['style' => 'width: 15%;'],
                        'format' => 'raw',
                        'value' => function ($model) {

                            if ($user = $model->user) {
                                $name = $user->name ?? '';
                                $imageUrl = $user->profile_display_image ?: $this->params['baseurl'] . '/img/dpmain.png';

                                return Html::a(
                                    Html::img($imageUrl, [
                                        'class' => "rounded profile-picture",
                                        'style' => "width:28px;"
                                    ]) . ' ' . Html::encode($name),
                                    ['/user/default/profile', 'user_id' => $user->id],
                                    ['style' => 'color:black !important;']
                                );
                            }

                            return '';
                        },
                    ],

                    [
                        'label' => 'Partner Name',
                        'contentOptions' => ['style' => 'width: 1%; text-align: center;'],

                        // 'headerOptions' => ['style' => 'width: 15%;'],
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
                        // 'headerOptions' => ['style' => 'width: 10%; text-align: center;'],
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
                        'template' => '{view}',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return  Html::a('<i class="mdi mdi-eye"></i>', ['/posts/default/view', 'id' => $model->id], [
                                    'class' => 'action-icon',
                                    'title' => 'View',
                                ]);
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
                            // 'suspend' => function ($url, $model) {
                            //     return \backend\widgets\SuspendActiveButton::widget(['model' => $model, 'suspend_button_title' => 'Inactive', 'active_title' => 'Sighting', 'suspend_title' => 'Sighting']);
                            // },
                        ]
                    ],

                ],
            ]); ?>
        </div>
    </div>
</div>


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