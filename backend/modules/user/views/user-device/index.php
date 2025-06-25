<?php

use common\models\User;
use common\models\UserSession;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = 'List of Users With Devices';
$this->params['title'] = $this->title;
?>

<?= $this->render('_search', ['model' => $searchModel]) ?>
<div class="card">
    <div class="card-body">

        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'headerOptions' => ['style' => 'width:5%']
                    ],
                    [
                        'label' => 'Full Name',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return Html::img(
                                $model->avatar != '' ? $model->avatar : '/img/dpmain.png',
                                ['class' => 'rounded profile-picture', 'style' => 'width:28px; margin-right:5px; vertical-align:middle;']
                            ) . ' ' . Html::encode($model->name);
                        }
                    ],
                    [
                        'label' => 'Email',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->username;
                        }
                    ],
                    [
                        'label' => 'No of Device',
                        'format' => 'raw',
                        'value' => function ($model) {
                            $device_count = UserSession::find()
                                ->where(['user_id' => $model->id])
                                ->andWhere(['not', ['firebase_token' => null]])->count();
                            return isset($device_count) ? $device_count : 0;
                        }
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => 'Action',
                        'headerOptions' => ['style' => 'width:15%;'],
                        'contentOptions' => ['style' => 'width:15%;'],
                        'template' => '{view}',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return  Html::button(
                                    '<img src="' . $this->params['baseurl'] . '/img/view.png" alt="" width="25" height="25">',
                                    [
                                        'value' => Url::toRoute(['user-device', 'user_id' => $model->id]),
                                        'class' => 'btn pop-up p-0 change-menuicon',
                                        'title' => 'View',
                                    ]
                                );
                            },
                        ],
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>

<div class="modal fade" id="deviceAction" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header flageHeader">
                <h6 class="modal-title fs-5" id="exampleModalLabel">
                    List of Devices
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


    $('.pop-up').on('click', function () {
        $('#deviceAction').modal('show')
		.find('#modalContent')
		.load($(this).attr('value'));
	});


JS;
$this->registerJs($script);

?>