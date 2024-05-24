<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\User $user */

$request = Yii::$app->request->post();
$first_name = Yii::$app->request->post('BirdingtourRegistrationForm')['bussiness_name'];
$register_comapany_name = Yii::$app->request->post('BirdingtourRegistrationForm')['register_comapany_name'];
$website = Yii::$app->request->post('BirdingtourRegistrationForm')['website'];
$phone_no = Yii::$app->request->post('BirdingtourRegistrationForm')['phone_no'];

?>
<div class="verify-email">
    <p>Dear ,</p>
    <p>Welcome to <?= $$first_name ?>!</p>
    <p>
        We are delighted to have you join our community of adventure enthusiasts and wildlife explorers. Your registration with [Safari Tour Operator Name] has been successfully completed, and we can't wait to embark on an unforgettable safari experience with you.
        Thank you for choosing [Safari Tour Operator Name]. We look forward to providing you with an extraordinary safari experience that you will cherish forever.
    </p>
    <p> Best regards,</p>

    <p><?= $first_name ?></p>
    <p>Safari Tour Operator</p>
    <p><?= $register_comapany_name ?></p>
    <p><?= $phone_no ?></p>
    <p><?= $website ?></p>
</div>