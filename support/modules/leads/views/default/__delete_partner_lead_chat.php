<?php

use common\models\chat\ChatMessage;
use common\models\GeneralModel;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<?= $this->render('view', ['model' => $model, 'quotations' => $quotations, 'safari_operator_id' => $safari_operator_model->id, 'chat'=>$chat]) ?>

