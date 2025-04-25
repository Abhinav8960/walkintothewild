<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Compliance Documents';
$this->params['breadcrumbs_home_url'] = '/';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => '#'];
$this->params['breadcrumbs'][] = "Compliance Document View";
$this->params['title'] = $this->title;
?>



<div class="d-flex justify-content-end align-items-start" style="margin-left: 10px; margin-top: 10px;">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="col-md-12 text-end" style="margin-bottom: 20px;">
        <?php
        if (isset($model->versions)) {
            $versions = $model->getVersions()->orderBy(['id' => SORT_DESC])->all();
            $versionList = \yii\helpers\ArrayHelper::map($versions, 'version', 'version');
            echo $form->field($model_version, 'version', [
                'inputOptions' => ['id' => 'compliance_documents_version']
            ])->dropDownList(
                $versionList,
                [
                    'prompt' => 'Select a Version',
                    'onchange' => <<<JS
                                  var version = $(this).val();
                                  if (version) 
                                  {
                                    window.location.href = '/compliancedocuments/default/view?id={$model->id}&version=' + version;
                                   }
                                JS
                ]
            )->label(false);
        }
        ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<div class="card">
    <div class="card-body">
        <div class="row">
        <div class="col-md-5">
                <div class="text-box">
                    <p>
                        <span>Current Version : </span><?= $model_version->version ?>
                    </p>
                </div>
            </div>
            <div class="col-md-5">
                <div class="text-box">
                    <p>
                        <span>Title :  </span><?= $model->title ?>
                    </p>
                </div>
            </div>

            <div class="col-md-5">
                <div class="text-box">
                    <p>
                        <span>Policy For : </span><?= $model->policy_for ?>
                    </p>
                </div>
            </div>

            <div class="col-md-5">
                <div class="text-box">
                    <p>
                        <span>Effective from : </span><?= $model->effective_from ?>
                    </p>
                </div>
            </div>

            <div class="col-md-5">
                <div class="text-box">
                    <p>
                        <span>Effective To : </span><?= $model->effective_to ?>
                    </p>
                </div>
            </div>


            <div class="col-md-12">
                <div class="border p-3 overflow-auto bg-light fs-6 rounded-3">
                    <p>
                        <span class="fw-bold text-dark">Description:</span> <?= $model_version->description ?>
                    </p>
                </div>
            </div>

            <div class="col-md-4 mt-4">
                <div class="text-box">
                    <p>
                        <span>Meta Title : </span><?= $model->meta_title ?>
                    </p>
                </div>
            </div>
            <div class="col-md-4 mt-4">
                <div class="text-box">
                    <p>
                        <span> Meta Description : </span><?= $model->meta_description ?>
                    </p>
                </div>
            </div>
            <div class="col-md-4 mt-4">
                <div class="text-box">
                    <p>
                        <span>Meta KeyWords : </span><?= $model->meta_keywords ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="text-box">
            </div>
        </div>

        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <div class="row">

            <div class="col-md-12">
                <div class="form-group">
                    <?= Html::a('Back', ['index'], ['class' => 'btn btn-orange text-white']) ?>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>

</div>

<style>
    .text-box p span {
        color: brown !important;
    }
</style>