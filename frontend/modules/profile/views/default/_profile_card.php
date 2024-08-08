<?php

use yii\helpers\Url;

?>


<div class="card_profile card h-100 position-relative">
    <div class="dots-blockbox">
        <i class="fa-solid fa-ellipsis"></i>
        <div class="box_dropdown">
            <?php if (Yii::$app->user->id != $user->id) { ?>
                <a href="<?= Url::toRoute(['/profile/search/blocked', 'user_handle' => $user->user_handle]) ?>" class="">Blocked</a>

            <?php } ?>
        </div>
    </div>

    <!-- <div class="card-up cover_profile">
            <img src="<?= $user->cover_image <> '' ?  $user->coverimage : $this->params['baseurl'] . '/img/banner-share.png' ?>" alt="" style="width: 100%; height: 130px;">
        </div> -->
    <div class="profileDetails  text-center">
        <a href="<?= Url::toRoute(['/profile/default/index', 'user_handle' => $user->user_handle]) ?>">
            <div class=" mx-auto white">
                <img src="<?= $user->profileimage ? $user->profileimage : $this->params['baseurl'] . '/img/user.png' ?>" class="rounded-circle img-fluid" alt="profile-image">

            </div>
            <div class="card-body text-center  pt-2">
                <h6 class="fs-4 fw-bold usename"><?= $user->name ?></h6>
                <!-- <h6 class="card-title "><?= $user->userhandle ?></h6> -->
                <h6 class="fs-6 joint-text">Joined July 2024</h6>
                <div class="followres-count pt-3">
                    <h6 class="folloerwstext">50 Followers</h6>
                </div>
            </div>
        </a>
        <div class="followunfollowbtn border-top ">
            <div class="row">
                <div class="col-6 divider">
                    <div class="folollowBtns ">
                        <button>Unfollow</button>
                    </div>
                </div>
                <div class="col-6">
                    <div class="massegses">
                        <button>Massege</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>



<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dots = document.querySelectorAll('.dots-blockbox');

        dots.forEach(dot => {
            const icon = dot.querySelector('.fa-ellipsis');
            const box = dot.querySelector('.box_dropdown');

            icon.addEventListener('click', function(event) {
                event.stopPropagation();
                const currentlyOpen = document.querySelector('.box_dropdown.show');
                if (currentlyOpen && currentlyOpen !== box) {
                    currentlyOpen.classList.remove('show');
                    currentlyOpen.style.display = 'none';
                }
                box.style.display = box.style.display === 'none' || !box.style.display ? 'block' : 'none';
                box.classList.toggle('show');
            });
        });

        document.addEventListener('click', function() {
            const openBox = document.querySelector('.box_dropdown.show');
            if (openBox) {
                openBox.style.display = 'none';
                openBox.classList.remove('show');
            }
        });
    });
</script>