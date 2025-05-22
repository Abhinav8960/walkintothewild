<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\User $user */

?>
<div class="verify-email">
    <p>Dear <?= Html::encode($username) ?>,</p>
    <p>Welcome to Walk Into The Wild!</p>
    <p>Unfortunately, you were recently unfollowed by <?= Html::encode($name) ?>.</p><br>
    <p>Stay tuned for updates!</p>
    <p>Team Walk into the Wild</p>
    <p><a href="https://www.walkintothewild.in" style="text-align:center !important;color:blue !important;">www.walkintothewild.in</a></p>
</div>
