<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Mail Log';
$this->params['breadcrumbs_home_url'] = '/';
$this->params['breadcrumbs'][] = "Mail Log View";
$this->params['title'] = $this->title;
?>

<?= Yii::$app->controller->renderpartial("@common//mail/{$master_mail_template->path}",json_decode($model->params,true)) ?>