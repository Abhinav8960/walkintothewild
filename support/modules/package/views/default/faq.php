<?php

/* @var $this yii\web\View */
/* @var $model apps\models\employee\Employee */

use common\models\package\PackageVersion;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;

$faq_count = 1;

$webasset = $this->assetManager->getBundle('\support\assets\NovaAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$this->title = 'Package : ' . $package_version_model->package_name . '';

?>
<?= $this->render('_form_upper_view', ['package' => $package_version_model]) ?>


<div class="tabs-formswrapper mx-3">
    <?= $this->render('_navbar', ['package' => $package_version_model, 'faq_active' => 'active']) ?>

    <div class="tabs-content-wraps">

        <div class="tab-pane" id="FAQ" role="tabpanel" aria-labelledby="FAQ-tab">
            <div class="accordionMianBox">
                <?php if ($faqs) {
                    foreach ($faqs as $i => $faq) { ?>
                        <div class="accordionItems">
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item mb-3">
                                    <?php
                                    echo $this->render('faq_form', ['model' => $faq, 'faq_model' => $faq, 'question_no' => $faq_count, 'drop_down_list' => $drop_down_list, 'url' => Url::toRoute(['update-faq', 'id' => $package_version_model->id, 'package_id' => $package_version_model->package_id, 'faq_id' => $faq->id])]);
                                    ?>
                                </div>
                            </div>
                        </div>
                <?php
                        $faq_count++;
                    }
                } ?>
                <div class="accordionItems">
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item mb-3">
                            <?php
                            echo $this->render('faq_form', ['model' => $model, 'question_no' => $faq_count, 'drop_down_list' => $drop_down_list]);
                            ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>