<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\master\airport\MasterAirportSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<?php $form = ActiveForm::begin([
    'options' => [
        'data-pjax' => true,
        'id' => 'Searchform'
    ],
    'method' => 'get',
    'fieldConfig' => [
        'template' => '{input}{error}',
    ],
]); ?>
<div class="row">


    <div class="col-md-3">
        <?= $form->field($model, 'user_id') ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'reference_id') ?>
    </div>

    

    <?php // echo $form->field($model, 'order_id') 
    ?>

    <?php // echo $form->field($model, 'currency') 
    ?>

    <?php // echo $form->field($model, 'lead_partner_id') 
    ?>

    <?php // echo $form->field($model, 'lead_id') 
    ?>

    <?php // echo $form->field($model, 'partner_id') 
    ?>

    <?php // echo $form->field($model, 'park_id') 
    ?>

    <?php // echo $form->field($model, 'addional_notes') 
    ?>

    <?php // echo $form->field($model, 'safaris') 
    ?>

    <?php // echo $form->field($model, 'travelers') 
    ?>

    <?php // echo $form->field($model, 'stay_category_id') 
    ?>

    <?php // echo $form->field($model, 'name') 
    ?>

    <?php // echo $form->field($model, 'email') 
    ?>

    <?php // echo $form->field($model, 'phone') 
    ?>

    <?php // echo $form->field($model, 'start_date') 
    ?>

    <?php // echo $form->field($model, 'end_date') 
    ?>

    <?php // echo $form->field($model, 'validity_date') 
    ?>

    <?php // echo $form->field($model, 'permit_booking_date') 
    ?>

    <?php // echo $form->field($model, 'partner_selling_price') 
    ?>

    <?php // echo $form->field($model, 'plateform_partner_fees_percentage') 
    ?>

    <?php // echo $form->field($model, 'plateform_partner_fees') 
    ?>

    <?php // echo $form->field($model, 'partner_net_selling_price') 
    ?>

    <?php // echo $form->field($model, 'plateform_customer_discount') 
    ?>

    <?php // echo $form->field($model, 'net_payment_price') 
    ?>

    <?php // echo $form->field($model, 'installment') 
    ?>

    <?php // echo $form->field($model, 'received_amount') 
    ?>

    <?php // echo $form->field($model, 'addtional_data') 
    ?>

    <?php // echo $form->field($model, 'datetime_of_approval_by_admin') 
    ?>

    <?php // echo $form->field($model, 'quotation_filepath') 
    ?>

    <?php // echo $form->field($model, 'is_payment_received') 
    ?>

    <?php // echo $form->field($model, 'transaction_datetime') 
    ?>

    <?php // echo $form->field($model, 'payment_gateway') 
    ?>

    <?php // echo $form->field($model, 'billing_name') 
    ?>

    <?php // echo $form->field($model, 'created_at') 
    ?>

    <?php // echo $form->field($model, 'updated_at') 
    ?>

    <?php // echo $form->field($model, 'created_by') 
    ?>

    <?php // echo $form->field($model, 'updated_by') 
    ?>

    <?php // echo $form->field($model, 'billing_address') 
    ?>

    <?php // echo $form->field($model, 'billing_city') 
    ?>

    <?php // echo $form->field($model, 'billing_state') 
    ?>

    <?php // echo $form->field($model, 'billing_zip') 
    ?>

    <?php // echo $form->field($model, 'billing_country') 
    ?>

    <?php // echo $form->field($model, 'billing_tel') 
    ?>

    <?php // echo $form->field($model, 'billing_email') 
    ?>

    <?php // echo $form->field($model, 'param1') 
    ?>

    <?php // echo $form->field($model, 'param2') 
    ?>

    <?php // echo $form->field($model, 'param3') 
    ?>

    <?php // echo $form->field($model, 'param4') 
    ?>

    <?php // echo $form->field($model, 'param5') 
    ?>

    <?php // echo $form->field($model, 'device') 
    ?>

    <?php // echo $form->field($model, 'platform') 
    ?>

    <?php // echo $form->field($model, 'platform_version') 
    ?>

    <?php // echo $form->field($model, 'browser') 
    ?>

    <?php // echo $form->field($model, 'browser_version') 
    ?>

    <?php // echo $form->field($model, 'application_version') 
    ?>

    <?php // echo $form->field($model, 'status') 
    ?>

    <div class="col-md-3">
        <?= Html::submitButton('Search', ['class' => 'btn btn-orange text-white']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>