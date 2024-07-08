<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\User $user */

?>
<div class="verify-email" style="text-align:center">
    <h4 style="text-align:center">THANK YOU</h4>
    <p style="text-align:center"> We request you to fill your details here <a href="<?= Yii::$app->params['frontend_url'] ?>sharedsafari/default/userdetail?token=<?= Html::encode($token) ?>"><?= Yii::$app->params['frontend_url'] ?>sharedsafari/default/userdetail?token=<?= Html::encode($token) ?></a>. </p>
    <p style="text-align:center">Stay tuned for updates!</p>
    <p style="text-align:center">Team Walk into the Wild</p>
    <p style="text-align:center"><a href="https://www.walkintothewild.in" style="text-align:center !important;color:blue !important;">www.walkintothewild.in</a></p>
    <p><img src="https://staging-manage.walkintothewild.in/img/logo.png"></p>
</div>