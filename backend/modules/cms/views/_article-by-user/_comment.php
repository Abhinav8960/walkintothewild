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
        <?php echo $this->render('_comment_search', ['model' => $searchModel]); ?>
        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'comment',
                    'statuslabel:raw',
                    'created_at:dateTime:Created at',
                    [
                        'label' => 'Action',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            if ($model->flaged == 1) {
                                return Html::button('<img src="/img/update.png" alt="" width="25" height="25">', [
                                    'value' => Url::toRoute(['view', 'id' => $model->id]),
                                    'class' => 'btn btn-warning choose-option mb-2',
                                    'title' => 'Edit'
                                ]);
                            } else {
                                return "";
                            }
                        }
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