<?php

/* @var $this yii\web\View */
/* @var $model apps\models\employee\Employee */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Package: ' . $package_version_model->package_name;
?>
<?= $this->render('_form_upper_view', ['package' => $package_version_model]) ?>

<div class="panel panel-primary tabs-style-2">
    <?= $this->render('_navbar', ['package' => $package_version_model, 'overview_active' => 'active']) ?>

    <div class="panel-body tabs-menu-body main-content-body-right border">
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