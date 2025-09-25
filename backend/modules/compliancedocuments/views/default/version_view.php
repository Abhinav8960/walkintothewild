<?php

use common\models\compliancedocuments\ComplianceDocuments;
use common\models\compliancedocuments\ComplianceDocumentsVersion;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Compliance Document Preview';
$this->params['breadcrumbs_home_url'] = '/';
$this->params['breadcrumbs'][] = "Compliance Documents Preview";
$this->params['title'] = $this->title;


?>

<div class="container-fluid mt-5">
    <div class="card shadow-sm p-3">
        <div class="card-body">

            <div class="row mb-3">
                <div class="col-md-3 col-sm-6 mb-2">
                    <p><strong>Type : </strong> <?= Html::encode(ComplianceDocumentsVersion::compliancedocumenttype($model->type)) ?></p>
                </div>
                <div class="col-md-3 col-sm-6 mb-2">
                    <p><strong>Effective Date : </strong><?= Yii::$app->formatter->asDate($model->effective_date) ?></p>
                </div>
                <div class="col-md-3 col-sm-6 mb-2">
                    <p><strong>Created At : </strong>  <?= Yii::$app->formatter->asDate($model->created_at) ?></p>
                </div>
                <div class="col-md-3 col-sm-6 mb-2">
                    <p><strong>Created By : </strong> <?= Html::encode($model->user->name) ?></p>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-12">
                    <div class="border p-3 bg-light rounded-3">
                        <p><strong>Content:</strong><br> <?= nl2br(Html::encode($model->content)) ?></p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<style>
    p strong {
        color: brown !important;
    }
</style>