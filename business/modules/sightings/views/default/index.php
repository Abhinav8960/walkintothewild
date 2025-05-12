<?php

use yii\helpers\Html;

use yii\widgets\Pjax;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = 'Sightings';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
// $this->params['buttons'][] = Html::a('Create',  ['create'], ['class' => 'btn btn-orange', 'title' => 'Create']);
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
                        // 'headerOptions' => ['style' => 'width: 10%; text-align: center;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return Html::tag('div', Html::img($model->thumbnail, [
                                'alt' => 'Uploaded Video',
                            ]), ['style' => 'text-align: center;']);
                        }
                    ],
                    [
                        'label' => 'Sighting Date',
                        'headerOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return date("F j, Y", strtotime($model->post_datetime));
                        }
                    ],
                    [
                        'label' => 'Animal',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->animalDetail->name;
                        }
                    ],
                    [
                        'label' => 'Session',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->safariSessionDetail->title;
                        }
                    ],
                    [
                        'label' => 'Park',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->locationDetail->title;
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
                            return $model->comments_count;
                        }
                    ],
                    [
                        'label' => 'Likes',
                        'contentOptions' => ['style' => '10%; text-align: right;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->likes_count;
                        }
                    ],
                    [
                        'label' => 'Duration',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->v_duration . ' seconds';
                        }
                    ],
                    [
                        'label' => 'Last Updated',
                        'headerOptions' => ['style' => 'width: 15%'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return date("F j, Y, g:i a", $model->updated_at);
                        }
                    ],
                    [
                        'label' => 'Status',
                        'contentOptions' => ['style' => 'width: 10%; text-align: left;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->newstatuslabel;
                        }
                    ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => "Actions",
                        'contentOptions' => ['style' => 'width: 10%; text-align: left;'],
                        'template' => '{view}&nbsp',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return Html::a(
                                    Html::img($this->params['baseurl'] . '/img/view.png', ['alt' => '', 'width' => 25, 'height' => 25]),
                                    [
                                        Url::toRoute(['/sightings/default/view', 'id' => $model->id]),
                                    ],
                                    [
                                        'class' => 'btn p-0 change-menuicon sighting-popup',
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

<?php Pjax::end(); ?>

<!-- 
<div class="modal fade" id="modalAction" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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


<?php
$script = <<< JS

    // $('.sighting-popup').on('click', function () {
    //     $('#modalAction').modal('show')
	// 	.find('#modalContent')
	// 	.load($(this).attr('value'));
	// });

    $('.comment-popup').on('click', function () {
        $('#commentAction').modal('show')
		.find('#commentContent')
		.load($(this).attr('value'));
	});

JS;
$this->registerJs($script);
?>