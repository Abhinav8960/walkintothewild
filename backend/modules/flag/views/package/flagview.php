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
          <td class="px-3"><?= ucfirst($review->comment) ?></td>
        </tr>
        <tr>
          <td class="px-3"><b>Package:</b></td>
          <td class="px-3"><?= $review->package->package_name ?></td>
        </tr>
        <tr>
          <td class="px-3"><b>Comment By:</b></td>
          <td class="px-3"><?= $review->user->name ?></td>
        </tr>
        <tr>
          <td class="px-3"><b>Date:</b></td>
          <td class="px-3"><?= date('d-m-Y', $review->created_at) ?></td>
        </tr>
        <tr>
          <td class="px-3"><b>Status:</b></td>
          <td class="px-3">
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

<div class="card">
  <div class="card-body">
    <div id="w1-button" class="mb-3"></div>
    <div class="table-responsive">
      <?php $form = ActiveForm::begin(['id' => 'action-form']); ?>
      <table class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>#</th>
            <th>Date</th>
            <th>Flagged Reason</th>
            <th>Flagged Detail</th>
            <th style="width:250px;">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if (count($review_flags) > 0) {
            $counter = 1;
            foreach ($review_flags as $flags) { ?>
              <tr>
                <td><?= $counter ?>.</td>
                <td><?= date('d-m-Y', $flags->created_at) ?></td>
                <td><?= ucfirst($flags->reportreason->reason) ?></td>
                <td><?= ucfirst($flags->report_detail) ?></td>
                <td style="width:250px;">
                  <?php
                  if ($flags->status == 1) { ?>
                    <span>&nbsp;&nbsp; </span>
                    <input type="radio" id="radioignore<?= $flags->id ?>" name="flag_action[<?= $flags->id ?>]" value="3" <?php if ($flags->status == 3) {
                                                                                                                            echo "checked";
                                                                                                                          } ?>>
                    <label for="radioignore<?= $flags->id ?>">Ignore</label>
                    <span>&nbsp;&nbsp;&nbsp;&nbsp; </span>
                    <input type="radio" id="radiodelete<?= $flags->id ?>" name="flag_action[<?= $flags->id ?>]" value="2" <?php if ($flags->status == 2) {
                                                                                                                            echo "checked";
                                                                                                                          } ?>>
                    <label for="radiodelete<?= $flags->id ?>">Delete</label>
                  <?php
                  } else {
                    $c_status = "Ignore";
                    if ($flags->status == '2') {
                      $c_status = "Delete";
                    }
                    echo "<span>&nbsp;&nbsp; </span>" . $c_status;
                  } ?>
                </td>
              </tr><?php
                    $counter++;
                  }
                } ?>
        </tbody>
      </table>
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