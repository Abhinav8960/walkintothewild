<?php



$this->title = 'FAQ';
$this->params['breadcrumbs_home_url'] = '/';
$this->params['breadcrumbs'][] = "Create";
$this->params['title'] = $this->title;



?>


        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>