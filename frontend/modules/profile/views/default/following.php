<?php


use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;

$this->title = $user->name . ' | Following';
$this->params['title'] = $this->title;
?>
<section class="profile-wrapper">
    <div class="container-lg mb-5">
        <?= $this->render('@frontend/modules/profile/views/default/tablist', ['profile' => 'active', 'user' => $user]) ?>
    </div>
</section>
<section class="margin_bottomfooter">
    <div class="container-lg">
        <div class="row justify-content-center mb-5">
            <div class="col-xxl-11 mb-5">
                <div class="row  mb-5">
                    <div class="col-md-12">
                        <h6 class="fs-5 fw-bold pb-3">Following</h6>
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <?php if ($userfollowers = $user->getUserfollowings()->where(['status' => 1])->all()) {
                                        foreach ($userfollowers as $userfollower) { ?>
                                            <div class="col-md-4 col-lg-3 col-sm-6 mb-3">

                                                <?= $this->render('@frontend/modules/profile/views/default/_profile_card', ['user' => $userfollower->follower, 'profile_user' => $user]);  ?>

                                            </div>
                                    <?php  }
                                    } else {
                                        echo '<div class="col-md-12">
                    There is no following!
                </div>';
                                    } ?>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</section>

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