<?php

use common\models\GeneralModel;
use common\models\package\PackageVersion;
use yii\helpers\Html;
use yii\helpers\Url;



?>
<section class="topHead mx-3 ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="topParent d-flex justify-content-between align-items-center">
                    <div class="packageTitle">
                        <h2>Package : <?= Html::encode($package->package_name) ?></h2>
                    </div>
                    <div class="d-flex justify-content-center gap-2">

                        <div class="deletionBtn">
                            <?= Html::a('Delete', [Url::toRoute(['delete', 'id' => $package->id])], ['title' => 'Send For Approval']) ?>
                        </div>
                        <?php if ($package->status == PackageVersion::EDIATBLE_STATUS) { ?>
                            <div class="edinBtn">
                                <?= Html::a('Send For Approval', [Url::toRoute(['send-for-approval', 'id' => $package->id])], ['title' => 'Send For Approval']) ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .deletionBtn a {
        background-color: rgb(212, 86, 51);
        color: #ffffff;
        border: 0;
        border-radius: 4px;
        font-size: 15px;
        font-weight: 700;
        padding: 10px 50px;
    }
</style>