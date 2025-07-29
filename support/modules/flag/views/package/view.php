<?php


/* @var $this yii\web\View */
/* @var $model common\models\corporate\Corporate */

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Package Flags';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;

$this->params['baseurl'] = $this->assetManager->getBundle('\support\assets\NovaAppAsset')->baseUrl;

?>
<div class="table-wrapper">
    <div class="table-responsive">
        <div class="min-width-table">
        <div class='row align-items-center mt-3 '>
            <table class="table table-striped table-bordered">
                <tr>
                    <td class="px-5 col-md-3"><b>Comment:</b></td>
                    <td class="px-5 wrap-text"><?= ucfirst($review->comment) ?></td>
                </tr>
                <tr>
                    <td class="px-5"><b>Package:</b></td>
                    <td class="px-5"><?= isset($review->package) ? ucfirst($review->package->package_name) : '' ?></td>
                </tr>
                <tr>
                    <td class="px-5"><b>Comment By:</b></td>
                    <td class="px-5"><?= isset($review->user) ?  ucfirst($review->user->name) : '' ?></td>
                </tr>
                <tr>
                    <td class="px-5"><b>Date:</b></td>
                    <td class="px-5"><?= date('d-m-Y', $review->created_at) ?></td>
                </tr>
                <tr>
                    <td class="px-5"><b>Status:</b></td>
                    <td class="px-5">
                        <?php
                        $c_status = "Active";
                        if ($review->status == '2') {
                            $c_status = "Delete";
                        }
                        echo $c_status; ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
</div>

<div class="table-wrapper mt-3">
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
                            return  isset($model->reportreason) ? $model->reportreason->reason : '';
                        }

                    ],

                    [
                        'label' => 'Flagged Detail',
                        'contentOptions' => ['style' => 'width: 10%;'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return  $model->report_detail;
                        }
                    ],

                    [
                        'label' => 'Action',
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
                            return Html::button('<i class="mdi mdi-eye"></i>', [
                                'value' => Url::toRoute(['edit', 'id' => $model->id]),
                                'class' => 'btn p-0 change-menuicon flag-action mb-2',
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

<style>
    .tablecustoms tbody .wrap-text {
        white-space: normal !important;
        text-overflow: initial !important;
    }
</style>