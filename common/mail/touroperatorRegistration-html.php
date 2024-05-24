<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\User $user */

$request = Yii::$app->request->post();
print_r($request);
die();
?>
<div class="verify-email">
    <p>Dear ,</p>
    <p>Welcome to [Safari Tour Operator Name]!</p>
    <p>
        We are delighted to have you join our community of adventure enthusiasts and wildlife explorers. Your registration with [Safari Tour Operator Name] has been successfully completed, and we can't wait to embark on an unforgettable safari experience with you.
        Thank you for choosing [Safari Tour Operator Name]. We look forward to providing you with an extraordinary safari experience that you will cherish forever.
    </p>
</div>