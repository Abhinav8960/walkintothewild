<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

?>

<div class="container mt-5" style="min-height: 620px;">
    <div class="row justify-content-center">
        <div class="col-12 pb-5">
            <div class="title_request">
                <h4 class="text-center fs-3">Please send your Details</h4>
            </div>
        </div>
        <div class="col-lg-6 mb-5 pb-5">
            <div class="card_request ">
            <div class="row">
                <div class="col-12">
                    <div class="formInput pt-lg-0 pt-2">
                        <label for="">Name <span>*</span></label>
                        <div class="mb-3 field-safaritourregistrationform-business_name required">
                            <input type="text" id="safaritourregistrationform-business_name" class="form-control ">

                        </div>
                    </div>
                    <div class="formInput pt-lg-0 pt-2">
                        <label for="">Email <span>*</span></label>
                        <div class="mb-3 field-safaritourregistrationform-business_name required">
                            <input type="text" id="safaritourregistrationform-business_name" class="form-control ">

                        </div>
                    </div>
                    <div class="formInput pt-lg-0 pt-2">
                        <label for="">Phone <span>*</span></label>
                        <div class="mb-3 field-safaritourregistrationform-business_name required">
                            <input type="text" id="safaritourregistrationform-business_name" class="form-control ">

                        </div>
                    </div>

                    <div class="submit_request">
                        <button class="btn_newsafari organizeBtn w-100">Submit</button>
                    </div>
                </div>
            </div>
            </div>
        

        </div>
    </div>
</div>