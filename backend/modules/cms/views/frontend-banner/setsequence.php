<?php

use common\models\cms\frontendbanner\FrontendBannerSearch;

$this->title = 'Update Sequence';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
?>
<?php
if ($types) {
    foreach ($types as $type_model) {
        $type = $type_model->type;

        // Four thing that will make to be dynamic for multiple sequence
        $reorderHelper = 'reorderHelper' . $type;
        $saveReorder = 'saveReorder' . $type;
        $reoder_list = 'reorder-privacy-list' . $type;
        $reorder_link = 'reorder_link' . $type;
?>
        <div class="card">
            <div class="tab-content p-4">
                <div class="tab-pane fade show active">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="text-center">Update Sequence of <?= isset($type_model->name) ? $type_model->name : '' ?></h4>
                                <a href="javascript:void(0);" class="<?= $reorder_link ?> btn btn-info" id="<?= $saveReorder ?>">Click to Update <?= isset($type_model->name) ? $type_model->name : '' ?> Sequence</a>
                                <div id="<?= $reorderHelper ?>" class="light_box" style="display:none;">1. Drag Location to update sequence.<br>2. Click 'Save Updated Sequence' when finished.</div>
                                <div class="gallery">
                                    <ul class="reorder_ul <?= $reoder_list ?>" style="list-style: none; padding-left:0rem;">
                                        <?php
                                        $searchModel = new FrontendBannerSearch();
                                        $searchModel->type = $type;
                                        $dataProvider = $searchModel->search(null, false);
                                        $models = $dataProvider->models;
                                        if ($models) {
                                            foreach ($models as $model) {
                                        ?>
                                                <li id="<?php echo $model->id; ?>" class="ui-sortable-handle py-2 px-2" style="border:1px solid black;">
                                                    <a href="javascript:void(0);" class="menuitem_link">
                                                        <?php echo  '<img src="' . $model->imagepath . '" style="width:50px;">'; ?>
                                                    </a>
                                                </li>
                                        <?php }
                                        }
                                        ?>
                                    </ul>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <?php
        $form_validate_url = \yii\helpers\Url::toRoute(["/cms/frontend-banner/savesequence"]);
        $script = <<< JS
            $(document).ready(function() {
                $('.{$reorder_link}').on('click', function() {
                    $("ul.{$reoder_list}").sortable({
                        tolerance: 'pointer'
                    });
                    $('.{$reorder_link}').html('Save Updated Sequence');
                    $('.{$reorder_link}').attr("id", "{$saveReorder}");
                    $('#{$reorderHelper}').slideDown('slow');
                    $('.menuitem_link').attr("href", "javascript:void(0);");
                    $('.menuitem_link').css("cursor", "move");
                    $("#{$saveReorder}").click(function(e) {
                        if (!$("#{$saveReorder} i").length) {
                            $(this).html('').prepend('<i class="fa fa-refresh"></i>');
                            $("ul.{$reoder_list}").sortable('destroy');
                            $("#{$reorderHelper}").html("Updating Package Banner Sequence - This could take a moment. Please don't navigate away from this page.").removeClass('light_box').addClass('notice notice_error');
                            var h = [];
                            $("ul.{$reoder_list} li").each(function() {
                                h.push($(this).attr('id'));
                            });
                            $.ajax({
                                type: "POST",
                                url: "{$form_validate_url}",
                                data: {
                                    ids: " " + h + ""
                                },
                                success: function(data) {
                                    window.location.reload();
                                }
                            });
                            return false;
                        }
                        e.preventDefault();
                    });
                });
            });
        JS;
        $this->registerJs($script);
        ?>
<?php    }
} ?>