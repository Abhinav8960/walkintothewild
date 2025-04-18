<?php

/* @var $this yii\web\View */
/* @var $model apps\models\employee\Employee */

$this->title = 'Fixed Departure : ' . $shared_safari_departure_model->share_safari_title . '';
$this->params['breadcrumbs_home_url'] = '#';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
?>
<div class="panel panel-primary tabs-style-2">
    <?= $this->render('_navbar', ['shared_safari_departure_model' => $shared_safari_departure_model, 'getting_there_active' => 'active']) ?>

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