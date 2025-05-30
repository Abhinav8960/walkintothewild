<?php

use yii\helpers\Url;
use yii\web\JqueryAsset;

$this->title = 'Change Order of Images in Photo Gallery with Drag and Drop';
$this->params['title'] = $this->title;
?>

<div class="card">
    <div class="box-body">
        <div class="col-md-12">
            <ul class="list-unstyled d-flex gap-2" id="gallery_list">
                <?php foreach ($dataProvider->models as $model): ?>
                    <li id="<?= $model->id ?>">
                        <div class="card" style="width: 18rem;">
                            <img src="<?= $model->gallery_image ?>" class="card-img-top" alt="ALT IMG" width="100" height="100">
                            <div class="card-body">
                                <h5><?= $model->title ?></h5>
                                <p class="card-text"><?= $model->caption ?></p>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
            <div id="submit-container">
                <input type='button' class="btn btn-info mb-2" value='Submit' id='submit' />
            </div>
        </div>
    </div>
</div>

<?php
$this->registerCssFile('https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');
$this->registerJsFile('https://code.jquery.com/ui/1.12.1/jquery-ui.min.js', [
    'depends' => [JqueryAsset::class],
]);

$form_validate_url = Url::to(['/gallery/default/update-sequence']);

$script = <<<JS
$(function() {
    
    $("#gallery_list").sortable({
        placeholder: "ui-state-highlight"
    });

    $('#submit').click(function (e) {
            e.preventDefault();
            
            var gallery_id_array = [];
            $('#gallery_list li').each(function() {
                gallery_id_array.push($(this).attr("id"));
            });

            $.ajax({
                url: "{$form_validate_url}",
                method: "POST",
                data: {
                    ids: gallery_id_array,
                    _csrf: yii.getCsrfToken()
                },
            
            success: function(data) {
                location.reload();
            },

            error: function(xhr) {
                alert("Error: " + xhr.responseText);
            }
        });
    });
});
JS;

$this->registerJs($script);
?>

<style>
    #gallery_list li {
        padding: 16px;
        background-color: #f9f9f9;
        border: 1px dotted #ccc;
        cursor: move;
        margin-top: 12px;
    }

    #gallery_list li.ui-state-highlight {
        padding: 24px;
        background-color: #ffffcc;
        border: 1px dotted #ccc;
        cursor: move;
        margin-top: 12px;
    }
</style>