<?php

/* @var $this yii\web\View */
/* @var $model apps\models\employee\Employee */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;

$faq_count = 1;

$webasset = $this->assetManager->getBundle('\business\assets\PartnerAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$this->title = 'Fixed Departure : ' . $shared_safari_departure_version_model->share_safari_title . '';
// $this->params['title'] = $this->title;
?>
<?= $this->render('_form_upper_view', ['shared_safari_departure_version_model' => $shared_safari_departure_version_model]) ?>


<div class="tabs-formswrapper mx-3">
    <?= $this->render('_navbar', ['shared_safari_departure_version_model' => $shared_safari_departure_version_model, 'faq_active' => 'active']) ?>

    <div class="tabs-content-wraps">

        <div class="tab-pane" id="FAQ" role="tabpanel" aria-labelledby="FAQ-tab">
            <div class="accordionMianBox">
                <?php if ($faqs) {
                    foreach ($faqs as $i => $faq) { ?>
                        <div class="accordionItems">
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item mb-3">
                                    <?php
                                    echo $this->render('faq_form', ['model' => $faq, 'faq_model' => $faq, 'question_no' => $faq_count, 'drop_down_list' => $drop_down_list, 'url' => Url::toRoute(['update-faq', 'id' => $shared_safari_departure_version_model->id, 'faq_id' => $faq->id])]);
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