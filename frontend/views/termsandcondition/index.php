<?php

use common\models\cms\contentmanagement\ContentManagement;
use common\models\GeneralModel;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$this->title = 'Safari Tour Operator Registration';
$this->params['title'] = $this->title;
?>

<section class="banner_section-inner position-relative">
    <picture class="position-relative">
        <source srcset="<?= $this->params['baseurl'] ?>/img/t&c.jpg" media="(max-width:576px)" type="image/webp">
        <img src="<?= $this->params['baseurl'] ?>/img/t&c.jpg" class="d-block w-100 " alt="banner">
    </picture>

</section>
<section class="terms_wrapper">
    <div class="container-lg">
        <div class="row pb-5 mb-5">
            <div class="col-12">
                <div class="title_terms">
                    <h2>Terms of Use</h2>
                </div>
            </div>
            <div class="col-12">
                <div class="terms_details">
                    <?php
                    $content = ContentManagement::findOne(['id' => ContentManagement::CM_TERM_AND_CONDITION]);
                    ?>
                    <div class="content_terms">
                        <p><?= htmlspecialchars(strip_tags($content ? $content->content : 'No content available'), ENT_QUOTES, 'UTF-8') ?></p>
                    <a href="mailto:contact@walkintothewild.in">contact@walkintothewild.in</a></p>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
if (isset($key) && !empty($key)) { ?>
    <!--    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#termsmodal">
        Agree modal
    </button> -->
    <div class="modal fade _standard-text" id="termsmodal" tabindex="-1" aria-labelledby="exampleModalLabel" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <?php $form = ActiveForm::begin([
                    'id' => 'tag-form',
                    'method' => 'POST',
                    'fieldConfig' => [
                        'template' => '<div class="form-group">{label}{input}{error}</div>',
                    ],
                ]); ?>
                <div class="modal-header justify-content-center">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Terms & conditions</h1>
                </div>
                <div class="modal-body px-3">
                    <div class="row">
                        <div class="col-12">
                            <div class="content_terms">
                                <h5>terms & conditions</h5>
                                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Saepe quam molestiae est quae placeat perferendis, reiciendis minus, dolorem nobis facere molestias blanditiis vitae distinctio. Nulla inventore ratione maiores quidem facilis?</p>
                                <div class="termsagree">
                                    <label for="agree"><?= $form->field($model, 'status')->checkbox(['class' => 'agreeterms'])->label("I agreen to this <strong><a href='/termsandcondition' target='_blank'>terms & constions</a></strong>"); ?> </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="/" class="backtohome">Back to Home</a>
                    <?= Html::submitButton('Agree', ['class' => 'btns_submit']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div><?php
            $script = <<< JS
        $('#termsmodal').modal('show');

        $('#termsmodal').on('click', '.modal-backdrop', function(e){
            e.preventDefault();
        });

        $(document).ready(function () {
            $(document).on('keydown', function(e){
                if (e.key === "Escape") {
                    alert('dsfsda');
                    console.log('just try');
                    window.location.href = "/";
                }
            });

            $('#termsmodal').on('show.bs.modal',
                function (event) {
                    $(this).data('bs.modal')._config.backdrop = 'static';
                    $(this).data('bs.modal')._config.keyboard = false;
                }
            );
        });
    JS;
            $this->registerJs($script);
        }
            ?>