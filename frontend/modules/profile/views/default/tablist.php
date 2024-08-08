<?php

use yii\helpers\Url;
use common\models\UserFollow;
use common\models\registration\SafariOperatorRequest;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
?>

<div class="profile_coverbnner mt-5 pt-5">
    <div class="container-lg">
        <div class="row justify-content-center">
            <div class="col-xxl-10 banner-cover position-relative">
                <img src="<?= $user->cover_image <> '' ?  $user->coverimage : $this->params['baseurl'] . '/img/banner-share.png' ?>" alt="" class=" banner-cover">
                <?php if (Yii::$app->user->id == $user->id) { ?>
                    <label for="coverImageUpload" class="coverbtns">
                        <i class="fa-solid fa-cloud-arrow-up"></i> <span>Upload Cover Picture</span>
                    </label>
                    <input type="file" id="coverImageUpload" style="display: none;" accept="image/*">
                <?php } ?>
            </div>
        </div>
        <div class="row align-items-center justify-content-center">
            <div class="mt-n5">
                <div class="d-flex align-items-center justify-content-center mb-4">
                    <div class="linear-gradient d-flex align-items-center justify-content-center rounded-circle">
                        <div class="border border-4 border-white d-flex align-items-center justify-content-center  profile_img">
                            <img src="<?= $user->profileimage <> '' ?  $user->profileimage : $this->params['baseurl'] . '/img/user.png' ?>" alt="" class="w-100 h-100">
                            <?php if (Yii::$app->user->id == $user->id) { ?>
                                <label for="profileImageUpload" class="camera-icon">
                                    <i class="fas fa-camera"></i>
                                </label>
                                <input type="file" id="profileImageUpload" style="display: none;" accept="image/*">
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <h6 class="fs-3 mb-0 fw-semibold"><?= $user->name ?></h6>
                </div>
                <div class="text-center">
                    <h6 class="mb-0"><?= $user->userhandle ?></h6>
                </div>
                <?php if ($user->user_bio <> '') { ?>
                    <div class="text-center pt-2 userBio">
                        <p class="mb-0  "><?= $user->user_bio ?></p>
                    </div>
                <?php } ?>
            </div>
            <div class="col-lg-7 " style="z-index: 10;">
                <div class="follow_massage d-flex justify-content-center mt-4 gap-3 align-items-center">
                    <?php if (Yii::$app->user->identity && Yii::$app->user->identity->id != $user->id) {
                        if (UserFollow::find()->where(['user_id' => Yii::$app->user->identity->id, 'follow_user_id' => $user->id, 'status' => '1'])->one()) { ?>
                            <a href="<?= Url::toRoute(['/profile/default/unfollow', 'user_handle' =>  $user->user_handle]) ?>" class="follow_btn" data-method="POST">Unfollow</a>
                        <?php } else { ?>
                            <a href="<?= Url::toRoute(['/profile/default/follow', 'user_handle' =>  $user->user_handle]) ?>" class="follow_btn " data-method="POST">Follow</a>
                        <?php } ?>
                        <a href="<?= Url::toRoute(['/chat/default/message', 'user_handle' => $user->user_handle]) ?>" class="follow_massge">Message</a>
                    <?php } else { ?>
                        <a href="<?= Url::toRoute(['/account', 'id' =>  $user->id]) ?>" class="follow_massge rounded-2"><i class="fa fa-edit"></i> Edit Profile</a>
                    <?php } ?>
                    <?php if (Yii::$app->user->identity && Yii::$app->user->identity->id == $user->id) {
                        if ($user->is_safari_operator != 1 && in_array($user->account_type, [2, 3])) {
                            $business_request = SafariOperatorRequest::find()->where(['user_id' => $user->id])->one();
                            if ($business_request) { ?>
                                <a href="<?= Url::toRoute(['/profile/business']) ?>" class="follow_massge rounded-2 text-capitalize">Pending Business Request</a>
                            <?php } else { ?>
                                <a href="<?= Url::toRoute(['/safaritour-registration']) ?>" class="follow_massge rounded-2 text-capitalize">Create Your Page </a>
                            <?php }
                            ?>
                        <?php }
                        ?>
                    <?php } ?>

                </div>

            </div>
        </div>
        <div class="row justify-content-center margin_n5">
            <div class="col-xxl-11">
                <div class="row justify-content-between align-items-center border-bottom pb-3">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center flowers-content">
                            <p class="mb-0"><a href="<?= Url::toRoute(['/profile/default/follower', 'user_handle' => $user->user_handle]) ?>"> <?= $user->getUserfollowers()->where(['status' => 1])->count(); ?> Followers</a></p>
                            <p class="mb-0"><a href="<?= Url::toRoute(['/profile/default/following', 'user_handle' => $user->user_handle]) ?>"> <?= $user->getUserfollowings()->where(['status' => 1])->count(); ?> Following</a></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="sociel_icons float-md-end">
                            <ul>
                                <?php if ($user->facebook_url) { ?>
                                    <li><a href="<?= $user->facebook_url; ?>" target="_blank" class="iconSize"><i class="fa-brands fa-facebook-f"></i></a>
                                    </li>
                                <?php } ?>
                                <?php if ($user->whatsapp_url) { ?>
                                    <li><a href="<?= $user->whatsapp_url; ?>" target="_blank" class="iconSize"><i class="fa-brands fa-whatsapp"></i></a>
                                    </li>
                                <?php } ?>
                                <?php if ($user->x_url) { ?>
                                    <li><a href="<?= $user->x_url; ?>" target="_blank" class="iconSize"><i class="fa-brands fa-x-twitter"></i></a>
                                    </li>
                                <?php } ?>
                                <?php if ($user->insta_url) { ?>
                                    <li><a href="<?= $user->insta_url; ?>" target="_blank" class="iconSize"><i class="fa-brands fa-instagram"></i></a>
                                    </li>
                                <?php } ?>
                                <?php if ($user->website_url) { ?>
                                    <li><a href="<?= $user->website_url; ?>" target="_blank" class="iconSize"><i class="fa-solid fa-globe"></i></a>
                                    </li>
                                <?php } ?>
                                <?php if ($user->youtube_url) { ?>
                                    <li><a href="<?= $user->youtube_url; ?>" target="_blank" class="iconSize"><i class="fa-brands fa-youtube"></i></a>
                                    </li>
                                <?php } ?>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row pt-5 itenary_tabs justify-content-center position-relative">
            <div class="col-xxl-11 safartabs d-flex  justify-content-between align-items-center position-relative">
                <ul class="nav nav-tabs slider_addmobile ">
                    <li class="nav-item"><a href="<?= Url::toRoute(['/profile/default/index', 'user_handle' => $user->user_handle]) ?>" class="nav-link <?= isset($profile) ? $profile : '' ?>">Profile</a></li>
                    <li class="nav-item"><a href="<?= Url::toRoute(['/profile/share-safari/index', 'user_handle' => $user->user_handle]) ?>" class="nav-link <?= isset($share_safari) ? $share_safari : '' ?>">Shared Safari</a></li>
                    <li class="nav-item"><a href="<?= Url::toRoute(['/profile/article/index', 'user_handle' => $user->user_handle]) ?>" class="nav-link <?= isset($article) ? $article : '' ?>">Article</a></li>
                    <!-- <li class="nav-item mobile-hidelink"><a href="<?= Url::toRoute(['/profile/activity/index', 'user_handle' => $user->user_handle]) ?>" class=" nav-link <?= isset($activity) ? $activity : '' ?>">Activity</a></li>
                    <?php if (Yii::$app->user->identity && $user->contribution_privacy == 2 && $user->id == Yii::$app->user->identity->id) { ?>
                        <li class="nav-item mobile-hidelink"><a href="<?= Url::toRoute(['/profile/contribution/index', 'user_handle' => $user->user_handle]) ?>" class="nav-link <?= isset($contribution) ? $contribution : '' ?>">Contribution</a></li>
                    <?php } elseif ($user->contribution_privacy == 3 && $user->userfollowers) {  ?>
                        <li class="nav-item mobile-hidelink"><a href="<?= Url::toRoute(['/profile/contribution/index', 'user_handle' => $user->user_handle]) ?>" class="nav-link <?= isset($contribution) ? $contribution : '' ?>">Contribution</a></li>
                    <?php } else { ?>
                        <li class="nav-item mobile-hidelink"><a href="<?= Url::toRoute(['/profile/contribution/index', 'user_handle' => $user->user_handle]) ?>" class="nav-link <?= isset($contribution) ? $contribution : '' ?>">Contribution</a></li>
                    <?php } ?> -->

                    <?php if (Yii::$app->user->identity && $user->photo_privacy == 2 && $user->id == Yii::$app->user->identity->id) { ?>
                        <li class="nav-item mobile-hidelink"><a href="<?= Url::toRoute(['/profile/photo/index', 'user_handle' => $user->user_handle]) ?>" class="nav-link <?= isset($photo) ? $photo : '' ?>">Photos</a></li>
                    <?php } elseif ($user->photo_privacy == 3 && $user->userfollowers) { ?>
                        <li class="nav-item mobile-hidelink"><a href="<?= Url::toRoute(['/profile/photo/index', 'user_handle' => $user->user_handle]) ?>" class="nav-link <?= isset($photo) ? $photo : '' ?>">Photos</a></li>
                    <?php } else { ?>
                        <li class="nav-item mobile-hidelink"><a href="<?= Url::toRoute(['/profile/photo/index', 'user_handle' => $user->user_handle]) ?>" class="nav-link <?= isset($photo) ? $photo : '' ?>">Photos</a></li>
                    <?php } ?>



                    <?php if (Yii::$app->user->identity && Yii::$app->user->identity->id == $user->id) {
                        if ($user->is_safari_operator == 1) { ?>
                            <li class="nav-item mobile-hidelink"><a href="<?= Url::toRoute(['/manage']) ?>" class="nav-link  <?= isset($business) ? $business : '' ?> " target="_blank">Manage Safari Tour Business <i class="fa fa-external-link"></i></a></li>
                    <?php }
                    } ?>
                </ul>
                <div class="sharerbtn">
                    <button value="<?= Url::toRoute(['/profile/default/share-profile']) ?>" class="follow_massge rounded-2 text-capitalize shareBtn mb-2 mobile-hidelink "><i class="fa-solid fa-share"></i> Share Profile</button>
                    <button value="" class="follow_massge rounded-2 text-capitalize  mb-2 d-lg-none mobile-more px-3"> More <i class="fa-solid fa-chevron-down"></i></button>
                </div>
            </div>
            <div class="moreviewMobile">
                <ul class="nav nav-tabs slider_addmobile flex-column">
                    <li class="nav-item mb-2"><a href="<?= Url::toRoute(['/profile/activity/index', 'user_handle' => $user->user_handle]) ?>" class=" nav-link <?= isset($activity) ? $activity : '' ?>">Activity</a></li>
                    <?php if (Yii::$app->user->identity && $user->contribution_privacy == 2 && $user->id == Yii::$app->user->identity->id) { ?>
                        <li class="nav-item mb-2"><a href="<?= Url::toRoute(['/profile/contribution/index', 'user_handle' => $user->user_handle]) ?>" class="nav-link <?= isset($contribution) ? $contribution : '' ?>">Contribution</a></li>
                    <?php } elseif ($user->contribution_privacy == 3 && $user->userfollowers) {  ?>
                        <li class="nav-item mb-2"><a href="<?= Url::toRoute(['/profile/contribution/index', 'user_handle' => $user->user_handle]) ?>" class="nav-link <?= isset($contribution) ? $contribution : '' ?>">Contribution</a></li>
                    <?php } else { ?>
                        <li class="nav-item mb-2"><a href="<?= Url::toRoute(['/profile/contribution/index', 'user_handle' => $user->user_handle]) ?>" class="nav-link <?= isset($contribution) ? $contribution : '' ?>">Contribution</a></li>
                    <?php } ?>

                    <?php if (Yii::$app->user->identity && $user->photo_privacy == 2 && $user->id == Yii::$app->user->identity->id) { ?>
                        <li class="nav-item mb-2"><a href="<?= Url::toRoute(['/profile/photo/index', 'user_handle' => $user->user_handle]) ?>" class="nav-link <?= isset($photo) ? $photo : '' ?>">Photos</a></li>
                    <?php } elseif ($user->photo_privacy == 3 && $user->userfollowers) { ?>
                        <li class="nav-item mb-2"><a href="<?= Url::toRoute(['/profile/photo/index', 'user_handle' => $user->user_handle]) ?>" class="nav-link <?= isset($photo) ? $photo : '' ?>">Photos</a></li>
                    <?php } else { ?>
                        <li class="nav-item mb-2"><a href="<?= Url::toRoute(['/profile/photo/index', 'user_handle' => $user->user_handle]) ?>" class="nav-link <?= isset($photo) ? $photo : '' ?>">Photos</a></li>
                    <?php } ?>



                    <?php if (Yii::$app->user->identity && Yii::$app->user->identity->id == $user->id) {
                        if ($user->is_safari_operator == 1) { ?>
                            <li class="nav-item mb-2"><a href="<?= Url::toRoute(['/manage']) ?>" class="nav-link  <?= isset($business) ? $business : '' ?> " target="_blank">Manage Safari Tour Business <i class="fa fa-external-link"></i></a></li>
                    <?php }
                    } ?>
                </ul>
                <div class="sharerbtn">
                    <button value="<?= Url::toRoute(['/profile/default/share-profile']) ?>" class="follow_massge rounded-2 text-capitalize shareBtn mb-2 "><i class="fa-solid fa-share"></i> Share Profile</button>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade _standard-text" id="share-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Share Link</h1>

            </div>
            <div class="modal-body p-3">
                <div id='modalContent'>
                    <ul class="shrelinkssss ps-0">
                        <?= \frontend\widgets\ShareButton::widget([
                            'style' => 'horizontal',
                            'networks' => ['facebook', 'twitter', 'instagram', 'whatsapp', 'linkedin', 'telegram', 'clipboard'],
                        ]); ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>



<style>
    .mt-n5 {
        margin-top: -5rem !important;
    }

    /* .linear-gradient {
        background-image: linear-gradient(#09422dfc, #f9d600);
    } */
</style>

<?php
$script = <<< JS
function popUpfunction() {
	$('.shareBtn').on('click', function () {
        $('#share-modal').modal('show')
		.find('#modalContent');
	});
}
popUpfunction();
             
JS;
$this->registerJs($script);
?>

<?php
$script = <<<JS
         $(document).ready(function() {
            $('#coverImageUpload').change(function(e){
                    e.preventDefault();
                    var formData = new FormData();
                    formData.append('file', e.target.files[0]);
                    $.ajax({
                    url: '/profile/default/cover-upload',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response){
                        if(response.success==true){                        
                            function success_notify(){
                                return notif({
                                    type: "success",
                                    msg: "Cover Picture uploaded successfully",
                                    position: "right",
                                });
                            }
                            location.reload();
                            }else{
                                function success_notify(){
                                    return notif({
                                        type: "error",
                                        msg: 'Error uploading Cover Picture ',
                                        position: "right",
                                    });
                                }
                        }
                    
                        // success_notify(); 
                        location.reload();

                    },
                    error: function(xhr, status, error){
                        function success_notify(){
                            return notif({
                                type: "error",
                                msg: 'Error uploading Cover Picture : ' + error,
                                position: "right",
                            });
                        }
                
                        success_notify(); 
                        location.reload();
                    }
                });
          });

          $('#profileImageUpload').change(function(e){
                    e.preventDefault();
                    var formData = new FormData();
                    formData.append('file', e.target.files[0]);
                    $.ajax({
                    url: '/profile/default/profile-upload', 
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response){
                        if(response.success==true){                        
                            function success_notify(){
                                return notif({
                                    type: "success",
                                    msg: "Profile Picture uploaded successfully",
                                    position: "right",
                                });
                            }
                            }else{
                                function success_notify(){
                                    return notif({
                                        type: "error",
                                        msg: 'Error uploading Profile Picture ',
                                        position: "right",
                                    });
                                }
                        }
                        location.reload();
                    
                        success_notify(); 
                    },
                    error: function(xhr, status, error){
                        function success_notify(){
                            return notif({
                                type: "error",
                                msg: 'Error uploading Profile Picture : ' + error,
                                position: "right",
                            });
                        }
                        location.reload();
                
                        success_notify(); 
                    }
                });
          });
        //   function initializeOwlCarousel() {
        //     if ($(window).width() <= 991) {
        //         $('.slider_addmobile').addClass('owl-carousel');
        //         $('.slider_addmobile').owlCarousel({
        //             loop: true,
        //             margin: 10,
        //             nav: false,
        //             dots: false,
        //             responsive: {
        //                 0: {
        //                     items: 2
        //                 },
        //                 600: {
        //                     items: 4
        //                 },
        //                 991: {
        //                     items: 4
        //                 }
        //             }
        //         });
        //     } else {
        //         $('.slider_addmobile').trigger('destroy.owl.carousel').removeClass('owl-carousel owl-loaded');
        //         $('.slider_addmobile').find('.owl-stage-outer').children().unwrap();
        //     }
        // }

        // initializeOwlCarousel();

        // $(window).resize(function() {
        //     initializeOwlCarousel();
        // });
    });
JS;
$this->registerJs($script);
?>

<script>
    let profile = document.querySelector('.mobile-more');
    let menu = document.querySelector('.moreviewMobile');

    profile.onclick = function(event) {
        event.stopPropagation(); // Prevents the click event from bubbling up to the document
        menu.classList.toggle('active');
    }

    document.onclick = function(event) {
        // Check if the clicked element is not the profile button or the menu
        if (!profile.contains(event.target) && !menu.contains(event.target)) {
            menu.classList.remove('active');
        }
    }
</script>