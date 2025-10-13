<?php

use common\models\compliancedocuments\ComplianceDocuments;
use common\models\compliancedocuments\ComplianceDocumentsVersion;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Compliance Document';
$this->params['breadcrumbs_home_url'] = '/';
$this->params['breadcrumbs'][] = "Compliance Documents";
$this->params['title'] = $this->title;


if ($model->status == ComplianceDocuments::STATUS_UNPUBLISHED) {
    $this->params['buttons'][] = Html::a('Publish', ['publish', 'id' => $model->id], ['class' => 'btn mt-2 btn-orange', 'title' => 'Publish']);
}

?>

<div class="container-fluid mt-5">
    <div class="card shadow-sm p-3">
        <div class="card-body">

            <div class="row mb-3">
                <div class="col-md-3 col-sm-6 mb-2">
                    <p><strong>Title : </strong> <?= Html::encode($model->labeltype) ?></p>
                </div>
                <!-- 
                <div class="col-md-3 col-sm-6 mb-2">
                    <p><strong>Banner Image : </strong>
                    <div class="external-preview border rounded p-2 bg-light text-center mt-1" style="width: 220px;">
                        <?php if (!empty($model->imagebannerpath)) : ?>
                            <img src="<?= $model->imagebannerpath ?>"
                                alt="Current Banner"
                                id="existingBanner"
                                class="img-fluid rounded"
                                style="max-height: 180px; object-fit: cover;">
                        <?php else : ?>
                            <div id="noImageText" class="text-muted small py-5">
                                No image<br>uploaded
                            </div>
                        <?php endif; ?>
                    </div>
                    </p>
                </div> -->

                <div class="col-md-3 col-sm-6 mb-2">
                    <?php if ($model->effective_date) { ?>
                        <p><strong>Effective Date : </strong><?= Yii::$app->formatter->asDate($model->effective_date) ?></p>
                    <?php } ?>
                </div>
                <div class="col-md-3 col-sm-6 mb-2">
                    <p><strong>Created At : </strong> <?= Yii::$app->formatter->asDate($model->created_at) ?></p>
                </div>
                <div class="col-md-3 col-sm-6 mb-2">
                    <p><strong>Created By : </strong> <?= Html::encode($model->user->name ?? '') ?></p>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="text-box border p-3 bg-light rounded-3">
                        <p><strong>Content:</strong><br> <?= $model->content ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-3">
            <?= Html::a('Back', ['index'], ['class' => 'btn btn-orange text-white']) ?>
        </div>

    </div>
</div>
</div>


<style>
    p strong {
        color: brown !important;
    }
</style>