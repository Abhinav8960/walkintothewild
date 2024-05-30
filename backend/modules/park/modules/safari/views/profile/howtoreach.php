<?php

/* @var $this yii\web\View */
/* @var $model apps\models\employee\Employee */

$this->title = 'Safari Park How To Reach';
$this->params['breadcrumbs_home_url'] = '#';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
?>
<div class="panel panel-primary tabs-style-2">
    <?= $this->render('@backend/modules/park/modules/safari/views/profile/_profile_navbar', ['safari_park' => $safari_model, 'howtoreach_active' => 'active']) ?>

    <div class="panel-body tabs-menu-body main-content-body-right border">
        <div class="tab-content">
            <div class="tab-pane active">
                <?= $this->render('_howtoreach_details_form', [
                    'model' => $model,
                ]) ?>
            </div>
        </div>
    </div>
</div>