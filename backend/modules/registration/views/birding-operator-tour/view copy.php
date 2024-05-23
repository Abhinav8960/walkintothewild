<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Safari Operator Tour Registrations';
$this->params['breadcrumbs_home_url'] = '/registration/safari-operator-tour';
$this->params['breadcrumbs'][] =  ['label' => 'Registration', 'url' => '#'];
$this->params['breadcrumbs'][] = 'View';
$this->params['title'] = $this->title;

$budget = [];
if ($model->birdingoperator_request_approval_model->is_offer_premium_budget == 1) {
    $budget[] = "Premium";
}
if ($model->birdingoperator_request_approval_model->is_offer_standard_budget == 1) {
    $budget[] = "Standard";
}
if ($model->birdingoperator_request_approval_model->is_offer_economical_budget == 1) {
    $budget[] = "Economical";
}

$html = '';
$activies = GeneralModel::operatorresquestactivties($model->birdingoperator_request_approval_model->is_offer_economical_budget);
foreach ($activies as $key => $role) {
    if (isset(GeneralModel::wildlifeactivities()[$key])) {
        $html .= GeneralModel::wildlifeactivities()[$key] . ', ';
    }
}
?>

<div class="card">

    <div class="card-body">

        <div class="row">
            <div class="col-md-3">
                <img src="<?= $model->birdingoperator_request_approval_model->Imagepath ?>">
            </div>
            <div class="col-md-3">
                <div class="text-box">
                    <p>
                        <span>Business Name:</span><?= $model->birdingoperator_request_approval_model->business_name ?>
                    </p>
                    <p>
                        <span>Address: </span><?= $model->birdingoperator_request_approval_model->address ?>
                    </p>
                    <p>
                        <span>Email Address: </span><?= $model->birdingoperator_request_approval_model->email ?>
                    </p>
                    <p>
                        <span>Registered Name: </span><?= $model->birdingoperator_request_approval_model->register_comapany_name ?>
                    </p>
                    <p>
                        <span>Category: </span><?= isset($model->birdingoperator_request_approval_model->category_id) ? GeneralModel::operatorcategory()[$model->birdingoperator_request_approval_model->category_id] : '' ?>
                    </p>

                </div>
            </div>
            <div class="col-md-3">
                <div class="text-box">
                    <p>
                        <span>Instagram Link: </span><a href="<?= $model->birdingoperator_request_approval_model->instagram_url ?>"><?= $model->birdingoperator_request_approval_model->instagram_url ?></a>
                    </p>
                    <p>
                        <span>Facebook Link: </span><a href="<?= $model->birdingoperator_request_approval_model->facebook_url ?>"><?= $model->birdingoperator_request_approval_model->facebook_url ?></a>
                    </p>
                    <p>
                        <span>Youtube Link: </span><a href="<?= $model->birdingoperator_request_approval_model->youtube_link ?>"><?= $model->birdingoperator_request_approval_model->youtube_link ?></a>
                    </p>

                    <p>
                        <span>Website: </span><a href="<?= $model->birdingoperator_request_approval_model->website ?>"><?= $model->birdingoperator_request_approval_model->website ?></a>
                    </p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="text-box">

                    <p>
                        <span>Google Rating: </span><?= $model->birdingoperator_request_approval_model->google_rating ?>
                    </p>
                    <p>
                        <span>Cancellation: </span><?= isset($model->birdingoperator_request_approval_model->has_cancellation_policy) ? GeneralModel::yesnooption()[$model->birdingoperator_request_approval_model->has_cancellation_policy] : '' ?>
                    </p>
                    <p>
                        <span>Budget Segment: </span><?= implode(', ', $budget) ?>
                    </p>
                    <p>
                        <span>Offers Other Wildlife Activities: </span><?= substr($html, 0, -2) ?>
                    </p>
                </div>
            </div>
        </div>
        <p>
            <span>About Business: </span><?= $model->birdingoperator_request_approval_model->about_business ?>
        </p>

        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <div class="row">

            <div class="col-md-6">
                <?= $form->field($model, 'comment')->textInput(['maxlength' => true, 'placeholder' => 'Enter Comment']) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'is_approved')->dropDownList(GeneralModel::yesnooption(), ['prompt' => 'Select Approval Option']) ?>
            </div>



            <div class="col-md-12">
                <div class="form-group">
                    <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-danger text-white']) ?>
                    <?= Html::submitButton('Save', ['class' => 'btn btn-orange text-white']) ?>
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