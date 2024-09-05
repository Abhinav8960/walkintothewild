<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\User $user */

?>
<div class="verify-email" style="text-align:center">
    <h4 style="text-align:center">THANK YOU</h4>
    <p style="text-align:center"> We request you to fill your details here <a href="https://www.walkintothewild.in/sharedsafari/default/userdetail?token=<?= Html::encode($token) ?>">Link</a>. </p>
    <p style="text-align:center">Stay tuned for updates!</p>
    <p style="text-align:center">Team Walk into the Wild</p>
    <p style="text-align:center"><a href="https://www.walkintothewild.in" style="text-align:center !important;color:blue !important;">www.walkintothewild.in</a></p>
    <p><img src="https://www.walkintothewild.in/img/logo.png"></p>
</div>
<?php if (!(isset($is_email_sending) && $is_email_sending)) { ?>
    <div class="card">
        <div class="card-body">
            <p>Keyword:</p>
            <p>1. token</p>
        </div>
    </div>
<?php } ?>