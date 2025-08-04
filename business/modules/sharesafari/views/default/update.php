<?php

/* @var $this yii\web\View */
/* @var $model apps\models\employee\Employee */

$this->title = 'Fixed Departure : ' . $shared_safari_departure_model->share_safari_title . '';
$this->params['breadcrumbs_home_url'] = '#';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
?>
<div class="tabs-formswrapper mx-3">
    <?= $this->render('_navbar', ['shared_safari_departure_model' => $shared_safari_departure_model, 'overview_active' => 'active']) ?>

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