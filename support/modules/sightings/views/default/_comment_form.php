<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

?>

<?php $form = ActiveForm::begin(['id' => 'comment-form']); ?>

<input type="hidden" value="TOKEN_HERE" name="_csrf-frontend">
<div class="comments-persons px-0 pt-4">
    <div class="postcomment d-flex gap-3">
        <!-- <div class="avatar"><a href="/user/default/profile?user_id=<?=$model->supportuser->id?>" data-discover="true"><img alt="" width="30" height="30" class="me-1 d-xl-inline-flex rounded-circle bg-info" src="<?= $model->supportuser->profile_display_image ?>"></a> -->
        <div class="avatar"><img alt="" width="30" height="30" class="me-1 d-xl-inline-flex rounded-circle bg-info" src="<?= $model->supportuser->profile_display_image ?>">

        </div>
        <div class="text-area">
            <div class="mb-3 field-sharesafaricommentform-comment required">
                <!-- <textarea id="sharesafaricommentform-comment" class="form-control w-100" name="ShareSafariCommentForm[comment]" rows="5" placeholder="Write a comment..."></textarea> -->
                <?= $form->field($comment_model, 'comment')->textarea([
                    'id' => 'sharesafaricommentform-comment',
                    'class' => 'form-control w-100',
                    'rows' => 5,
                    'placeholder' => 'Write a comment...'
                ])->label(false) ?>
            </div>
        </div>
    </div>
</div>

<div class="comments-persons px-4 pt-2">
    <div class="row justify-content-center">
        <div class="col-lg-12 col-xl-8">

        </div>
        <div class="col-lg-12 col-xl-4">
            <div class="comment_button float-end mb-lg-0 mb-3">
                <!-- <button type="submit" class="post-comment">Comment</button> -->
                <?= Html::submitButton('Comment', ['class' => 'post-comment']) ?>

            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>