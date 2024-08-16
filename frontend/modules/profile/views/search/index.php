<?php

use yii\helpers\Url;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;


$this->title = 'Search Profile';
$this->params['title'] = $this->title;
?>

<div class="container pt-5 mt-5">
    <div class="row mt-2">
        <div class="col-12">
            <h6 class="fs-3 fw-bold mb-4">Search Profile</h6>
        </div>
    </div>
    <div class="row margin_bottomfooter">
        <?php foreach ($user_list as $user) { ?>
            <div class="col-md-3 mb-4">
                <?= $this->render('@frontend/modules/profile/views/default/_profile_card', ['user' => $user, 'profile_user' => Yii::$app->user->identity]);  ?>
            </div>
        <?php } ?>
    </div>
</div>

<style>
    .testimonial-card .card-up {
        height: 120px;
        overflow: hidden;
        border-top-left-radius: .25rem;
        border-top-right-radius: .25rem;
    }

    .testimonial-card .avatar {
        width: 120px;
        margin-top: -60px;
        overflow: hidden;
        border: 5px solid #fff;
        border-radius: 50%;
    }
</style>


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