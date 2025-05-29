<?php

$this->title = 'Create Gallery';
$this->params['title'] = $this->title;

?>
<div class="panel panel-primary tabs-style-2">
    <div class="card">
        <div class="card-body">
            <?= $this->render('_gallery_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>