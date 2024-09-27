<?php

use yii\helpers\Html;

$this->title = $title;
$this->params['breadcrumbs_home_url'] = '/';
$this->params['breadcrumbs'][] =  ['label' => 'Portal Setting', 'url' => '#'];
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;

?>

<div class="card">
    <div class="card-header justify-content-between d-flex">
        <?= Html::a('<i class="fa fa-download"></i> Download', ['export', 'type' => $type], ['class' => 'btn btn-lg btn-success']) ?>
        <?= Html::a('<i class="fa fa-trash"></i> Clear', ['clear', 'type' => $type], ['class' => 'btn btn-lg btn-danger']) ?>
    </div>
    <div class="card-body">
        <?php echo '<pre>';
        echo $logs;
        echo '</pre>'; ?>
    </div>
</div>