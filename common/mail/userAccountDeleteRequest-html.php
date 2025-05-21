<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\User $user */

?>
<div class="verify-email">
    <p>Hello admin,</p>
    <p><a href="<?= \Yii::$app->params['backend_url'] . '/userdeleterequest/default/index' ?>" target="_blank"><?= Html::encode($username) ?></a> has request to delete <?= $email ?> account on Walk Into The Wild.</p>
    <p>Best regards,</p>
    <p>Team Walk into the Wild
        <?php if (isset(\Yii::$app->params['environment'])) {
           echo \Yii::$app->params['environment'] != 'production' ?  \Yii::$app->params['environment'] : '';
        } ?>
    </p>
</div>