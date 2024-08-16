<?php

use yii\helpers\Html;
use yii\grid\GridView;

$webasset = $this->assetManager->getBundle('\frontend\assets\FrontAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
$this->title = $safari_operator->businessname . ' | Manage Operator Business';

?>

<div class="container-lg mt-5 mb-5 pt-5 ">
    <div class="row margin_bottomfooter">
        <div class="col-md-12">
            <h6 class="fs-3 fw-bold mb-4"><?= $this->title ?></h6>
        </div>
        <div class="col-xxl-3 col-lg-4 mb-4">
            <?= $this->render('@frontend/modules/manage/views/default/_sidebar', ['active' => 'follower']); ?>
        </div>
        <div class="col-xxl-9 col-lg-8">
            <div class="card account-settingside">
                <div class="card-body p-4">
                    <div class="row">

                        <?php if ($followers = $follow_dataProvider->models) {
                            foreach ($followers as $follower) { ?>
                                <div class="col-md-3 col-lg-3 col-sm-6 mb-3">
                                    <section class="mx-auto" style="max-width: 23rem;">
                                        <?= $this->render('@frontend/modules/profile/views/default/_profile_card', ['user' => $follower->user, 'profile_user' => Yii::$app->user->identity]);  ?>
                                    </section>
                                </div>
                        <?php }
                        } else {
                            echo 'No Follower Found!';
                        } ?>
                        <div class="col-md-12">
                            <div class="table-responsive table_design_manage">
                                <?= GridView::widget([
                                    'dataProvider' => $follow_dataProvider,
                                    'layout' => '{summary}<br>{pager}',
                                ]); ?>
                            </div>
                        </div>
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