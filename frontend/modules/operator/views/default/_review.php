<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="row">
    <div class="col-12">
        <div class="comments_safari operator_comment">
            <div class="commentsOther  position-relative">
                <div class=" d-flex justify-content-between flex-wrap">
                    <div class="userRatingTitle">
                        <h6 class="nameRating">Avarage User Rating</h6>
                        <div class="providerNamerating d-flex gap-4 align-items-center pb-3">
                            <div class="ratings">
                                <p class="mb-0">4.8 <i class="fa-solid fa-star ms-2"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></p>
                            </div>
                            <div class="googlerating">
                                <p class="mb-0">54 Reviews</p>
                            </div>
                        </div>
                    </div>
                    <div class="whiteReview">
                        <button class="btn_review writeAReviewBtn" value="<?= Url::toRoute(['/operator/default/review', 'operator_id' => $operator->id]) ?>" data-bs-toggle="modal" data-bs-target="#exampleModal2">+ Write a Review</button>
                    </div>
                </div>
                <div class="sort_wrapper py-3">
                    <div class="sortBy">Sort by</div>
                    <button class="btn_sort active">Newest</button>
                    <button class="btn_sort">Highest</button>
                    <button class="btn_sort">Lowest</button>
                </div>
            </div>
            <div class="commentsOther  position-relative">
                <div class="objec-flgs">
                    <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/flag.png" alt="">
                </div>
                <div class="postcomment  pt-3">
                    <div class="text_com">
                        <h6 class="nameavatr">Jim cobbert National Park</h6>
                        <div class="providerNamerating d-flex gap-4 align-items-center pb-2">
                            <div class="ratings">
                                <p class="mb-0"> <i class="fa-solid fa-star ms-2"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></p>
                            </div>
                            <div class="googlerating">
                                <p class="mb-0">Rahul</p>
                            </div>
                        </div>
                        <p>Oh, that sounds amazing! I've always wanted to experience the thrill
                            of seeing
                            wild animals up close.</p>
                    </div>
                </div>
            </div>
            <div class="commentsOther position-relative">
                <div class="objec-flgs">
                    <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/flag.png" alt="">
                </div>
                <div class="postcomment  pt-3">
                    <div class="text_com">
                        <h6 class="nameavatr">Jim cobbert National Park</h6>
                        <div class="providerNamerating d-flex gap-4 align-items-center pb-2">
                            <div class="ratings">
                                <p class="mb-0"> <i class="fa-solid fa-star ms-2"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></p>
                            </div>
                            <div class="googlerating">
                                <p class="mb-0">Rahul</p>
                            </div>
                        </div>
                        <p>Oh, that sounds amazing! I've always wanted to experience the thrill
                            of seeing
                            wild animals up close.</p>
                    </div>
                </div>
            </div>
            <div class="commentsOther position-relative">
                <div class="objec-flgs">
                    <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/flag.png" alt="">
                </div>
                <div class="postcomment  pt-3">
                    <div class="text_com">
                        <h6 class="nameavatr">Jim cobbert National Park</h6>
                        <div class="providerNamerating d-flex gap-4 align-items-center pb-2">
                            <div class="ratings">
                                <p class="mb-0"> <i class="fa-solid fa-star ms-2"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></p>
                            </div>
                            <div class="googlerating">
                                <p class="mb-0">Rahul</p>
                            </div>
                        </div>
                        <p>Oh, that sounds amazing! I've always wanted to experience the thrill
                            of seeing
                            wild animals up close.</p>
                    </div>
                </div>
            </div>
            <div class="commentsOther position-relative">
                <div class="objec-flgs">
                    <img src="<?= $this->params['baseurl'] ?>/img/Share-Safari/flag.png" alt="">
                </div>
                <div class="postcomment  pt-3">
                    <div class="text_com">
                        <h6 class="nameavatr">Jim cobbert National Park</h6>
                        <div class="providerNamerating d-flex gap-4 align-items-center pb-2">
                            <div class="ratings">
                                <p class="mb-0"> <i class="fa-solid fa-star ms-2"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></p>
                            </div>
                            <div class="googlerating">
                                <p class="mb-0">Rahul</p>
                            </div>
                        </div>
                        <p>Oh, that sounds amazing! I've always wanted to experience the thrill
                            of seeing
                            wild animals up close.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>



<div class="modal fade _standard-text order--modal" id="review-write-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Write a Review</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id='modalContent'></div>
            </div>
        </div>
    </div>
</div>


<?php
$script = <<< JS
function writeareviewfunction() {
	$('.writeAReviewBtn').on('click', function () {
        $('#review-write-modal').modal('show')
		.find('#modalContent')
		.load($(this).attr('value'));
	});
}

writeareviewfunction();
             
JS;
$this->registerJs($script);
?>