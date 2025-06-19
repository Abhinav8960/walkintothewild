<?php

/* @var $this yii\web\View */
/* @var $model apps\models\employee\Employee */

$this->title = 'Package : ' . $package_version_model->package_name . '';
?>
<?= $this->render('_form_upper_view', ['package' => $package_version_model]) ?>

<div class="tabs-formswrapper">
    <?= $this->render('_navbar', ['package' => $package_version_model, 'getting_there_active' => 'active']) ?>

    <div class="tabs-content-wraps">
        <?= $this->render('_getting_there_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>