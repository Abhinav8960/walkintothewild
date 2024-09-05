<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<?php $form = ActiveForm::begin([
    'id' => 'comment-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => false,
    'enableClientScript' => true,
    // 'action' => $model->action_url,
    'validationUrl' => $model->action_validate_url,
]); ?>
<div class="comments-persons px-3 pt-4">
    <div class="postcomment d-flex gap-3">
        <div class="avatar">
            <a href="<?= Url::toRoute(['/profile/default/index', 'user_handle' => Yii::$app->user->identity && Yii::$app->user->identity->user_handle <> '' ? Yii::$app->user->identity->user_handle : '']) ?>">
                <img src="<?= Yii::$app->user->identity && Yii::$app->user->identity->profileImage <> '' ? Yii::$app->user->identity->profileImage : $this->params['baseurl'] . '/img/dpmain.png' ?>" alt="">
            </a>
        </div>
        <div class="text-area">
            <?= $form->field($model, 'comment')->textarea(['rows' => '5', 'placeholder' => 'Write a comment...', 'class' => 'form-control w-100'])->label(false) ?>
        </div>
    </div>
</div>
<div class="comments-persons px-3 pt-2">
    <div class="row justify-content-center">
        <div class="col-lg-12 col-xl-8">
            <div class="post_text padding_ad">
                <p>Commenting on this thread will notify all event attendees and will also be visible to
                    everyone viewing the event.</p>
            </div>
        </div>
        <div class="col-lg-12 col-xl-4 ">
            <div class="comment_button float-end mb-lg-0 mb-3">
                <?= Html::submitButton('Post Comment', ['class' => 'post-comment']) ?>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>