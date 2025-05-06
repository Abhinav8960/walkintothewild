<?php

$this->title = 'Compliance Documents';
$this->params['breadcrumbs_home_url'] = '/';
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => '/compliancedocuments'];
$this->params['breadcrumbs'][] = "Create";
$this->params['title'] = $this->title;
?>

<div class="card">
    <div class="card-body">
        <?= $this->render('_form', [
            'model' => $model,
            'model_version'=>$model_version
        ]) ?>
    </div>
</div>