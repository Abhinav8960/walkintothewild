<?php

/* @var $this yii\web\View */
/* @var $model apps\models\employee\Employee */

$this->title = 'Package : ' . $package_version_model->package_name . '';
?>

<?= $this->render('_form_upper_view', ['package' => $package_version_model]) ?>
<div class="tabs-formswrapper mx-3">
    <?= $this->render('_navbar', ['package' => $package_version_model, 'policy_info_active' => 'active']) ?>

    <div class="tabs-content-wraps">
        <?= $this->render('_policy_info_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>