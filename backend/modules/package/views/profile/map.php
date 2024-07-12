<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
/* @var $this yii\web\View */
/* @var $model apps\models\employee\Employee */

$this->title = 'Safari Park Map';
$this->params['breadcrumbs_home_url'] = '#';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;

?>
<div class="panel panel-primary tabs-style-2">
    <?= $this->render('@backend/modules/package/views/profile/_profile_navbar', ['package' => $package_model, 'map_active' => 'active']) ?>

    <div class="panel-body tabs-menu-body main-content-body-right border">
        <div class="tab-content">
            <div class="tab-pane active">
                <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
                <div class="card">
                    <div class="card-body">
                        <h5>Map Detail</h5>
                        <div class="row">
                            <div class="col-md-3">
                                <?= $form->field($model, 'latitude')->textInput(['maxlength' => true, 'placeholder' => 'Enter Latitude']) ?>
                            </div>

                            <div class="col-md-3">
                                <?= $form->field($model, 'longitude')->textInput(['maxlength' => true, 'placeholder' => 'Enter Longitude']) ?>
                            </div>

                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?= Html::submitButton('Save', ['class' => 'btn btn-orange text-white']) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
                <?php

                $latitude = $model->latitude;
                $longitude = $model->longitude;

                $mapUrl = "https://www.google.com/maps?q={$latitude},{$longitude}&hl=es;z=14&output=embed";

                if (!empty($latitude) && !empty($longitude)) {
                ?>

                    <iframe width="1500" height="450" frameborder="0" style="border:0" src="<?= $mapUrl ?>" allowfullscreen>
                    </iframe>

                <?php } ?>
            </div>
        </div>
    </div>
</div>