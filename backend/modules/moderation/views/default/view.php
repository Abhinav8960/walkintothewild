<?php


/* @var $this yii\web\View */
/* @var $model common\models\corporate\Corporate */

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Moderation';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;

?>


<div class="card">

    <div class="card-body">

        <div class="row">
            <div class="col-md-4">
                <?php if ($model->type == 2) { ?>
                    <video width='320' height='240' controls>
                        <source src="<?= Yii::$app->params['cloud_front_url'] . $model->video_url ?>" type='video/mp4'>
                    </video>
                <?php } else if ($model->type == 3) { ?>
                    <img src="<?= Yii::$app->params['cloud_front_url'] . $model->image_url ?>" alt="" srcset="">
                <?php } ?>
                <div class="col-md-8">
                    <h1> Meta Data </h1>
                    <?php
                    if ($model->type == 2 && $model->videoMetadata) {
                        $attributes = [];
                        foreach ($model->videoMetadata->metaAttributes as $key => $value) {
                            $attributes[] = "<strong>" . $key . ":</strong> " . $value;
                        } ?>
                        <?= implode('<br>', $attributes); ?>
                    <?php } else if ($model->type == 3 && $model->imageMetadata) {
                        $attributes = [];
                        foreach ($model->imageMetadata->metaAttributes as $key => $value) {
                            $attributes[] = "<strong>" . $key . ":</strong> " . $value;
                        } ?>
                        <?= implode('<br>', $attributes); ?>
                    <?php } ?>

                </div>
            </div>
            <?php if ($model->is_api_failed != 1) { ?>
                <div class="col-md-8">
                    <h1>Artifical Information</h1>
                    <?php
                    if ($model->type == 2) { ?>
                        <?= $model->tags ?>
                    <?php }
                    if ($model->type == 3) { ?>
                        <?= $model->imageDetails; ?>
                    <?php }
                    ?>
                </div>
            <?php } ?>

        </div>

    </div>

</div>