<?php

/* @var $this yii\web\View */
/* @var $model apps\models\employee\Employee */

$this->title = 'Package : ' . $package_model->package_name . '';
$this->params['breadcrumbs_home_url'] = '#';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
?>
<div class="panel panel-primary tabs-style-2">
    <?= $this->render('@backend/modules/package/views/profile/_profile_navbar', ['package' => $package_model, 'term_condition_active' => 'active']) ?>

    <div class="panel-body tabs-menu-body main-content-body-right border">
        <div class="tab-content">
            <div class="tab-pane active">

            </div>
        </div>
    </div>
</div>