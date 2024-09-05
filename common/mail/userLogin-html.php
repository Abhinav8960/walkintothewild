<?php

use common\models\User;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\User $user */

?>
<div class="verify-email">
    <p>Dear <?= Html::encode($username) ?>,</p>

    <p> You are successfully login to Walk into wild </p>
</div>
<?php if (!(isset($is_email_sending) && $is_email_sending)) { ?>
    <div class="card">
        <div class="card-body">
            <p>Keyword:</p>
            <p>1. username</p>
        </div>
    </div>
<?php } ?>