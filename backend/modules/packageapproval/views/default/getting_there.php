<?php

/* @var $this yii\web\View */
/* @var $model apps\models\employee\Employee */

$this->title = 'Package : ' . $package_model->package_name . '';
?>
<?= $this->render('_form_upper_view', ['package' => $package_model]) ?>

<div class="panel panel-primary tabs-style-2">
    <?= $this->render('_navbar', ['package' => $package_model, 'getting_there_active' => 'active']) ?>

    <div class="panel-body tabs-menu-body main-content-body-right border">
        <div class="tab-content">
            <div class="tab-pane active">
                <?= $this->render('_getting_there_form', [
                    'model' => $model,
                ]) ?>
            </div>
        </div>
    </div>
</div>