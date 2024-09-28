<?php

use yii\grid\GridView;

$this->title = 'Chat';

?>

<div class="container-fluid mt-5 mb-5 py-5">
    <div class="row mb-5">
        <div class="col-md-12">
            <h5><?= $this->title ?></h5>
        </div>
        <div class="col-md-2">
            <?= $this->render('@frontend/modules/chat/views/default/_sidebar', ['active' => 'safarioperator']); ?>
        </div>
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            
                        </div>
                        <div class="col-md-9 text-center">
                            Select a Operator
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>