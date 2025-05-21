<?php


/* @var $this yii\web\View */

use yii\helpers\Url;

$this->title = 'Sighting';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
?>


<div class="container-lg mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-xxl-12 m-5">
            <div class="row" style="height: 600px;">
                <iframe 
                    src="<?= Yii::$app->params['s3_endpoint'] .'/'. $sighting->filepath ?>" 
                    width="100%" 
                    height="100%" 
                    frameborder="0" 
                    allow="autoplay; fullscreen" 
                    allowfullscreen>
                </iframe>
            </div>
        </div>
    </div>
</div>
