<?php


/* @var $this yii\web\View */

use yii\helpers\Url;

$this->title = 'Post';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
?>


<div class="container-lg mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-xxl-12 m-5">
            <div class="row" style="height: 600px;">
                <img
                    src="<?= Yii::$app->params['cloud_front_url'] . $userpost->filepath ?>"
                    width="100%"
                    height="100%">
                </img>
            </div>
        </div>
    </div>
</div>