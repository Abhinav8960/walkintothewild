<?php

use yii\helpers\Html;

$this->title = 'Create External Operator';
$this->params['breadcrumbs_home_url'] = '/';
$this->params['breadcrumbs'][] = ['label' => 'External Operator', 'url' => '#'];
$this->params['breadcrumbs'][] = "Create";
$this->params['title'] = $this->title;

?>
 <div class="tabs-formswrapper">
    <div class="card border-0">
        <div class="card-body">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>