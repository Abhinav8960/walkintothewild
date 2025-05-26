<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\master\smstemplate\MasterSmsTemplate $model */

$this->title = 'SMS Template';
$this->params['breadcrumbs_home_url'] = '/master/sms-template';
$this->params['breadcrumbs'][] =  ['label' => 'Master', 'url' => '#'];
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
?>

<div class="card">
    <div class="card-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>