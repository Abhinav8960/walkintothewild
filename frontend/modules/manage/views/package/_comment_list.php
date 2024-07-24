<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<div class="table-responsive">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'contentOptions' => ['style' => 'width: 5%;'],
            ],
            [
                'label' => 'Date',
                'contentOptions' => ['style' => 'width: 15%;'],
                'format' => 'raw',
                'value' => function ($model) {
                    return date('Y-m-d', $model->created_at);
                }
            ],
            [
                'label' => 'Comment',
                'contentOptions' => ['style' => 'width: 10%;'],
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->comment;
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
                'label' => 'Action',
                'contentOptions' => ['style' => 'width: 10%;'],
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::button('View Replies', [
                        'value' => Url::toRoute(['replies', 'id' => $model->id]),
                        'class' => 'btn btn-warning choose-option mb-2',
                        'title' => 'Edit'
                    ]);
                }
            ],

        ],
    ]); ?>
</div>
<div class="modal fade" id="modalAction" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header flageHeader">
                <h6 class="modal-title fs-5" id="exampleModalLabel">
                    Action
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