<?php


use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\grid\GridView;
use yii\helpers\Url;

?>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'comment',
                    [
                        'label' => 'Flags',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return isset($model->reports) ? count($model->reports) : '0';
                        }
                    ],
                    'created_at:dateTime:Created at',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => "Actions",
                        'contentOptions' => ['style' => 'width: 10%; text-align: center;'],
                        'template' => '{flag}',
                        'buttons' => [
                            'flag' => function ($url, $model) {
                                return Html::button('<img src="' . $this->params['baseurl'] . '/img/view.png" alt="" width="25" height="25">', [
                                    'value' => Url::toRoute(['flagview', 'id' => $model->id]),
                                    'class' => 'btn btn-warning flag-option mb-2',
                                    'title' => 'Flag'
                                ]);
                            },
                        ]
                    ],
                ]
            ]); ?>
        </div>
    </div>
</div>
<?php
$script = <<< JS


    $('.flag-option').on('click', function () {
        $('#modalflagAction').modal('show')
		.find('#modalflagContent')
		.load($(this).attr('value'));
	});

JS;
$this->registerJs($script);
?>