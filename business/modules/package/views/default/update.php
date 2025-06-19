<?php

/* @var $this yii\web\View */
/* @var $model apps\models\employee\Employee */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Package: ' . $package_version_model->package_name;
?>
<?= $this->render('_form_upper_view', ['package' => $package_version_model]) ?>

<div class="tabs-formswrapper">

    <?= $this->render('_navbar', ['package' => $package_version_model, 'overview_active' => 'active']) ?>

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