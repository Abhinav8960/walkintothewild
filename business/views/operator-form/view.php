<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\UserForm $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'User Forms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-form-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'email:email',
            'phone_no',
            'whatsap_no',
            'dob',
            'gender',
            'kyc_detail',
            'business_registration_name',
            'business_brand_name',
            'business_full_name',
            'business_phone_no',
            'business_whatsap_no',
            'business_email_id:email',
            'business_logo_upload',
            'type_of_business',
            'business_doc_reg_no',
            'business_kyc_detail',
            'business_operated_park',
            'business_detail:ntext',
            'gst',
            'bank_name',
            'account_holder_name',
            'account_no',
            'ifsc_code',
            'cancle_check',
            'upload_adhar_no',
            'upload_aadhar_front',
            'upload_aadhar_back',
            'pan_no',
            'pan_upload',
            'upload_registration_number',
            'upload_registration_cert',
            'upload_document',
        ],
    ]) ?>

</div>
