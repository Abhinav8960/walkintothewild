<?php

/* @var $this yii\web\View */
/* @var $model apps\models\employee\Employee */

$this->title = 'Fixed Departure : ' . $shared_safari_departure_version_model->share_safari_title . '';
?>

<?= $this->render('_form_upper_view', ['shared_safari_departure_version_model' => $shared_safari_departure_version_model]) ?>

<div class="tabs-formswrapper mx-3">
    <?= $this->render('_navbar', ['shared_safari_departure_version_model' => $shared_safari_departure_version_model, 'overview_active' => 'active']) ?>

    <div class="tabs-content-wraps">

        <div class="tab-content">
            <div class="tab-pane active">
                <?= $this->render('_form', [
                    'model' => $model,
                    'safari_operator' => $safari_operator,

                ]) ?>
            </div>
        </div>
    </div>
</div>