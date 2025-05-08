<?php

use yii\helpers\Html;

use yii\widgets\Pjax;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = 'Posts';
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
                        'label' => 'File',
                        'contentOptions' => ['style' => 'width: 10%; text-align: center;'],
                        'headerOptions' => ['style' => 'width: 10%; text-align: center;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            if ($model->filepath) {
                                return Html::tag('div', Html::img(Yii::$app->params['cloud_front_url'] . $model->filepath, [
                                    'alt' => 'Uploaded Image',
                                    'height' => '240px',
                                    'width' => '320px'
                                ]), ['style' => 'text-align: center;']);
                            }
                            return '';
                        }
                    ],
                    [
                        'label' => 'Caption',
                        'contentOptions' => ['style' => 'width: 10%; text-align: center;'],
                        'headerOptions' => ['style' => 'width: 10%; text-align: center;'],

                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->caption;
                        }
                    ],
                    [
                        'label' => 'Comment Count',
                        'contentOptions' => ['style' => 'width: 10%; text-align: center;'],
                        'headerOptions' => ['style' => 'width: 10%; text-align: center;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return Html::button($model->comments_count, [
                                'value' => Url::toRoute(['comment-listing', 'id' => $model->id]),
                                'class' => 'comment-popup btn btn-info',
                            ]);
                        }
                    ],
                    [
                        'label' => 'Sighting Like Count',
                        'contentOptions' => ['style' => 'width: 10%; text-align: center;'],
                        'headerOptions' => ['style' => 'width: 10%; text-align: center;'],

                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->likes_count;
                        }
                    ],
                    [
                        'label' => 'Date',
                        'contentOptions' => ['style' => 'width: 10%; text-align: center;'],
                        'headerOptions' => ['style' => 'width: 10%; text-align: center;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return date('Y-m-d H:i:s', $model->created_at);
                        }
                    ],
                    [
                        'label' => 'Last Updated Time',
                        'contentOptions' => ['style' => 'width: 10%; text-align: center;'],
                        'headerOptions' => ['style' => 'width: 10%; text-align: center;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return date('Y-m-d H:i:s', $model->updated_at);
                        }
                    ],

                    [
                        'label' => 'Status',
                        'contentOptions' => ['style' => 'width: 10%; text-align: center;'],
                        'headerOptions' => ['style' => 'width: 10%; text-align: center;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->newstatuslabel;
                        }
                    ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => "Actions",
                        'contentOptions' => ['style' => 'width:50px; text-align:center;'],
                        'headerOptions' => ['style' => 'width:50px; text-align:center;'],
                        'template' => '{view}&nbsp',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                if ($model->file) {
                                    return Html::button(
                                        Html::img($this->params['baseurl'] . '/img/view.png', ['alt' => '', 'width' => 25, 'height' => 25]),
                                        [
                                            'value' => Url::toRoute(['/posts/default/view', 'id' => $model->id]),
                                            'class' => 'btn p-0 change-menuicon post-popup',
                                            'title' => 'View',
                                        ]
                                    );
                                }
                                return '';
                            },
                        ]
                    ],

                ],
            ]); ?>
        </div>
    </div>
</div>

<?php Pjax::end(); ?>


<div class="modal fade" id="modalAction" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
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
</div>


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

    $('.post-popup').on('click', function () {
        $('#modalAction').modal('show')
		.find('#modalContent')
		.load($(this).attr('value'));
	});

    $('.comment-popup').on('click', function () {
        $('#commentAction').modal('show')
		.find('#commentContent')
		.load($(this).attr('value'));
	});

JS;
$this->registerJs($script);
?>