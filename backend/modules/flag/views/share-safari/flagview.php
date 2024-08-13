<?php


/* @var $this yii\web\View */
/* @var $model common\models\corporate\Corporate */

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap5\ActiveForm;
use yii\helpers\ArrayHelper;

$this->title = 'Share Safari Comment Flag';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;

$this->params['baseurl'] = $this->assetManager->getBundle('\backend\assets\NovaAppAsset')->baseUrl; ?>

<div class="card">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-striped table-bordered">
        <tr>
          <td class="px-3"><b>Comment:</b></td>
          <td class="px-3"><?= $review->comment ?></td>
        </tr>
        <tr>
          <td class="px-3"><b>Park:</b></td>
          <td class="px-3"><?= $review->park->title ?></td>
        </tr>
        <tr>
          <td class="px-3"><b>Comment By:</b></td>
          <td class="px-3"><?= $review->user->name ?></td>
        </tr>
        <tr>
          <td class="px-3"><b>Date:</b></td>
          <td class="px-3"><?= date('d-m-Y', $review->created_at) ?></td>
        </tr>
      </table>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <div id="w1-button" class="mb-3"></div>
    <div class="table-responsive">
      <?php $form = ActiveForm::begin(['id' => 'action-form']); ?>

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
              return  $model->reportreason->reason;
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
              if ($model->status == 2) {
                $return = 'Delete';
              } else if ($model->status == 3) {
                $return = 'Ignore';
              } else if ($model->status == 20) {
                $return = 'Blocked User';
              }
              return $return;
            }
          ],

          [
            'label' => 'Admin Comment',
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
            'value' => function ($model, $form) {
              /*$temp = $form->field($model, "ignore_flag", [
                'labelOptions' => ['class' => 'bold_lable']
              ])->radioList($model->ignore_flag)->label('Ignored');*/
              return "";
            }
          ],

        ],
      ]); ?>
      <div class="form-group text-end">
        <?= Html::submitButton('Save', ['class' => 'btn btn-orange text-white float-right']) ?>
      </div>
      <?php ActiveForm::end(); ?>
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