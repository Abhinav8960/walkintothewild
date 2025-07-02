<?php


use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = 'Reply Report';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
?>
<div class="card">
    <div class="card-body">
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>

        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    // [
                    //     'label' => 'User',
                    //     'contentOptions' => ['style' => 'width: 20%;'],
                    //     'format' => 'raw',
                    //     'value' => function ($model) {
                    //         if ($user = $model->user) {
                    //             return Html::a($user->name, ['/user/default/profile', 'user_id' => $user->id], ['style' => 'color:black !important;']);
                    //         }
                    //         return $model->user_id;
                    //     }
                    // ],
                    [
                        'label' => 'User Name',
                        'headerOptions' => ['style' => 'width: 15%;'],
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
                        'label' => 'Share Safari Title',
                        'contentOptions' => ['style' => 'width: 20%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->sharesafari) ? $model->sharesafari->share_safari_title : "";
                        }
                    ],

                    [
                        'label' => 'Comment',
                        'contentOptions' => ['style' => 'width: 20%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->parent) ? $model->parent->comment : '';
                        }
                    ],

                    [
                        'label' => 'Reply',
                        'contentOptions' => ['style' => 'width: 20%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->comment;
                        }
                    ],
                    'created_at:dateTime:Created at',

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