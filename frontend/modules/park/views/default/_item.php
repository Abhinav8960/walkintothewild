<a href="/park/<?= $model->slug ?>" class="parking_Box">
    <div class="searchSafari_wraper mb-4">
        <div class="row">
            <div class="col-xl-3 col-sm-4 col-md-3">
                <div class="Slider_safariimg3 h-100">
                    <img src="<?= isset($model->logo) ? $model->logoimagepath : $this->params['baseurl'] . '/img/Bandhavgarhbig.jpg' ?>" alt="" class="w-100 h-100">
                </div>
            </div>
            <div class="col-md-9 col-sm-8 col-xl-9">
                <div class="safariSearch_wrap">
                    <div class="safrititles tite_parklist pt-sm-0 pt-3">

                        <h4 class=""><?= $model->title ?> | <span><?= isset($model->state) ? $model->state->state_name . ', ' : '' ?><?= isset($model->location) ? $model->location->title : '' ?></span></h4>

                    </div>
                    <div class="seelctes_text  pb-4 ">
                        <p>
                            <?= $model->long_description ?>
                        </p>
                    </div>
                    <div class="tour_logosliders">
                        <div class="taglines">
                            <p>Top Safari Tour Operators</p>
                        </div>
                        <div class="touroprators">
                            <div class="opratios-slider owl-carousel owl-theme">
                                <?php if ($operator_list = $model->getSafarioperatorlist()->joinwith(['operator' => function ($operator_park_query) {
                                    $operator_park_query->where(['safari_operator.status' => 1]);
                                }])->where(['safari_operator_park.status' => 1])->all()) {
                                    foreach ($operator_list as $operator_park) { ?>
                                        <div class="slidesImg">
                                            <img src="<?= isset($operator_park->operator->logo) ? $operator_park->operator->imagepath : $this->params['baseurl'] . '/img/Pugdundee.jpg' ?>" alt="" class="w-100">
                                        </div>
                                    <?php  }
                                    ?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</a>