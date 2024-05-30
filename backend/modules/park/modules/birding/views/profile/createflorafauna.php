<?php

/* @var $this yii\web\View */
/* @var $model apps\models\employee\Employee */

$this->title = 'Birding Park Flora & Fauna';
$this->params['breadcrumbs_home_url'] = '#';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
?>
<div class="panel panel-primary tabs-style-2">
    <?= $this->render('@backend/modules/park/modules/birding/views/profile/_profile_navbar', ['birding_park' => $birding_model, 'flora_fauna_active' => 'active']) ?>

    <div class="panel-body tabs-menu-body main-content-body-right border">
        <div class="tab-content">
            <div class="tab-pane active">
                <?= $this->render('_form_florafauna', [
                    'model' => $model,
                ]) ?>
            </div>
        </div>
    </div>
</div>