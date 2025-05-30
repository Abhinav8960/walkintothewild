<?php

use common\models\GeneralModel;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Mail Log';
$this->params['breadcrumbs_home_url'] = '/';
$this->params['breadcrumbs'][] = "Mail Log View";
$this->params['title'] = $this->title;
?>

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
            <h5 class="mb-3">Details</h5>
                <div class="text-box p-3 border rounded bg-light">
                    <div class="row mb-2">
                        <div class="col-md-4 fw-bold text-success">Subject:</div>
                        <div class="col-md-8"><?= Html::encode($model->subject ?? '') ?></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4 fw-bold text-success">Mail Template:</div>
                        <div class="col-md-8"><?= Html::encode($model->template->name ?? '') ?></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4 fw-bold text-success">Parameters:</div>
                        <div class="col-md-8">
                            <?php
                            $params = !empty($model->params) ? json_decode($model->params, true) : null;
                            ?>
                            <div class="col-md-12">
                                <?php if ($params): ?>
                                    <pre><?= Html::encode(json_encode($params, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)) ?></pre>
                                <?php else: ?>
                                    <span class="text-muted">No parameters</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4 fw-bold text-success">To Recipient:</div>
                        <div class="col-md-8"><?= Html::encode($model->torecipient->recipient ?? '') ?></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4 fw-bold text-success">AWS Message ID:</div>
                        <div class="col-md-8"><?= Html::encode($model->aws_message_id ?? '') ?></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4 fw-bold text-success">Mail Send Time:</div>
                        <div class="col-md-8"><?= Yii::$app->formatter->asDatetime(strtotime($model->mail_send_time), 'php:d M Y, h:i A') ?></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4 fw-bold text-success">Updated At:</div>
                        <div class="col-md-8"><?= Yii::$app->formatter->asDatetime($model->updated_at, 'php:d M Y, H:i A') ?></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4 fw-bold text-success">Status</div>
                        <div class="col-md-8"><?= $model->statuslabel ?? ''  ?></div>
                    </div>
                </div>

            </div>

            <div class="col-md-5 justify-content-center">
            <h5 class="mb-3">Mail Template Preview</h5>
            <div class="p-3 border rounded">
            <?= Yii::$app->controller->renderpartial("@common//mail/{$master_mail_template->path}",json_decode($model->params,true)) ?>
            </div>
            </div>
        </div>
    </div>
</div>