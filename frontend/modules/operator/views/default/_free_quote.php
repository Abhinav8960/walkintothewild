<?php

use yii\bootstrap5\ActiveForm;

?>
<div class="col-lg-12 col-xl-9">
    <div class="get_free_title">
        <h4>Get a FREE quote</h4>
    </div>
    <?php $form = ActiveForm::begin(['id' => 'reply-form']); ?>

    <div class="getquote_box">
        <div class="row ">
            <div class="col-lg-3">
                <div class="form-wrapper">
                    <label for="">Safari Park</label>
                    <select class="form-select mb-3" aria-label="Default select example">
                        <option selected="">Jim Corbett</option>
                        <option value="1">January</option>
                        <option value="2">Febraury</option>
                        <option value="3">March</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-wrapper d-flex gap-3">
                    <div class="input-group2 mb-3">
                        <label for="safaris">Safaris</label>
                        <div class="number-input position-relative">
                            <input type="number" id="safaris" value="6" class="form-control">
                            <div class="bton_updown">
                                <button onclick="increment('safaris')"><i class="fa-solid fa-chevron-up"></i></button>
                                <button onclick="decrement('safaris')"><i class="fa-solid fa-chevron-down"></i></button>
                            </div>
                        </div>

                    </div>
                    <div class="input-group2">
                        <label for="travelers">Travelers</label>
                        <div class="number-input position-relative">
                            <input type="number" id="travelers" value="6" class="form-control">
                            <div class="bton_updown">
                                <button onclick="decrement('travelers')"><i class="fa-solid fa-chevron-up"></i></button>
                                <button onclick="decrement('travelers')"><i class="fa-solid fa-chevron-down"></i></button>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-wrapper">
                    <label for="">Stay Category</label>
                    <select class="form-select mb-3" aria-label="Default select example">
                        <option selected="">Standard</option>
                        <option value="1">January</option>
                        <option value="2">Febraury</option>
                        <option value="3">March</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-wrapper">
                    <label for="">Start Date</label>
                    <input type="text" class="form-control">
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-wrapper">
                    <label for="">End Date</label>
                    <input type="text" class="form-control">
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-wrapper mb-3">
                    <label for="">Full Name</label>
                    <input type="text" class="form-control" placeholder="Your name">
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-wrapper mb-3">
                    <label for="">Email Address</label>
                    <input type="text" class="form-control" placeholder="xyz@abc.com">
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-wrapper mb-3">
                    <label for="">Email Address</label>
                    <input type="text" class="form-control" placeholder="+91">
                </div>
            </div>
            <div class="col-lg-3 margi_top pt-lg-0 pb-3">
                <button class="sent_btn">Send Request</button>
            </div>
            <div class="col-12">
                <div class="text_get">
                    <p><span>*</span>Your request will be sent directly to the operator, but you can
                        also contact them directly if you prefer.</p>
                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>