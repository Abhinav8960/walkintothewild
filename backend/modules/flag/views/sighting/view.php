<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Flags';
$this->params['title'] = $this->title;

$this->params['baseurl'] = $this->assetManager->getBundle('\backend\assets\NovaAppAsset')->baseUrl;

?>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <tr>
                    <td class="px-3"><b>Comment:</b></td>
                    <td class="px-3"><?= ucfirst($flag_comment->comment) ?></td>
                </tr>
                <tr>
                    <td class="px-3"><b>Comment By:</b></td>
                    <td class="px-3"><?= isset($flag_comment->user) ? ucfirst($flag_comment->user->name) : '' ?></td>
                </tr>
                <tr>
                    <td class="px-3"><b>Date:</b></td>
                    <td class="px-3"><?= date('d-m-Y', $flag_comment->created_at) ?></td>
                </tr>
                <tr>
                    <td class="px-3"><b>Status:</b></td>
                    <td class="px-3">
                        <?php
                        $c_status = "Active";
                        if ($flag_comment->status == '-1') {
                            $c_status = "Delete";
                        }
                        echo $c_status; ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>


<div class="card">
    <div class="card-body">
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
                        'label' => 'Date',
                        'contentOptions' => ['style' => 'width: 15%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return date('Y-m-d', $model->created_at);
                        }
                    ],

                    [
                        'label' => 'Flagged Reason',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return  isset($model->flagreason) ? $model->flagreason->reason : '';
                        }

                    ],

                    [
                        'label' => 'Flagged Detail',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return  $model->flag_detail;
                        }
                    ],
                    [
                        'label' => 'Status',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            $return = 'N/A';
                            if ($model->status == -1) {
                                $return = 'Delete';
                            } else if ($model->status == 2) {
                                $return = 'Ignore';
                            }
                            return $return;
                        }
                    ],

                    [
                        'label' => 'Admin Reason',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            $return = 'N/A';
                            if (!empty($model->reason)) {
                                $return = $model->reason;
                            }
                            return $return;
                        }
                    ],

                    [
                        'label' => 'Action',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return Html::button('<img src="' . $this->params['baseurl'] . '/img/update.png" alt="" width="25" height="25">', [
                                'value' => Url::toRoute(['edit', 'id' => $model->id]),
                                'class' => 'btn btn-warning flag-action mb-2',
                                'title' => 'Edit'
                            ]);
                        }
                    ],

                ],
            ]); ?>
        </div>
    </div>
</div>

<div class="modal fade" id="modalFlag" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
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

    $('.flag-action').on('click', function () {
        $('#modalFlag').modal('show')
		.find('#modalContent')
		.load($(this).attr('value'));
	});

JS;
$this->registerJs($script);
?>