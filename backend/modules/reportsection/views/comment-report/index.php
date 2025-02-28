<?php


use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\grid\GridView;
use yii\helpers\Url;


$this->title = 'Comment Report';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;


?>
<div class="commentCount mb-4">
    <h6> Comments</h6>
</div>
<div class="card">
    <div class="card-body">
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>

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
                    [
                        'label' => 'Share Safari Title',
                        'contentOptions' => ['style' => 'width: 20%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->sharesafari) ? $model->sharesafari->share_safari_title : "";
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
                            }
                        ]
                    ],

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