<?php

$this->title = 'Update Sequence of Suggestion Category';
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
?>
<div class="card">
    <div class="tab-content p-4">
        <div class="tab-pane fade show active">
            <div class="box-body">
                <div class="col-md-12">
                    <div class="col-md-12">
                        <h4 class="text-center"><?= $this->title ?></h4>
                        <a href="javascript:void(0);" class="reorder_link btn btn-info" id="saveReorder">Click to Update privacy Sequence</a>
                        <div id="reorderHelper" class="light_box" style="display:none;">1. Drag Suggestion Category to update sequence.<br>2. Click 'Save Updated Sequence' when finished.</div>
                        <div class="gallery">
                            <ul class="reorder_ul reorder-privacy-list" style="list-style: none; padding-left:0rem;">
                                <?php
                                $models = $dataProvider->models;
                                if ($models) {
                                    foreach ($models as $model) {
                                ?>
                                        <li id="<?php echo $model->id; ?>" class="ui-sortable-handle py-2 px-2" style="border:1px solid black;">
                                            <a href="javascript:void(0);" class="menuitem_link">
                                                <?php echo $model->title; ?>
                                            </a>
                                        </li>
                                <?php }
                                } ?>
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
$form_validate_url = \yii\helpers\Url::toRoute(["/master/suggestion-category/savesequence"]);
$script = <<< JS
    $(document).ready(function() {
        $('.reorder_link').on('click', function() {
            $("ul.reorder-privacy-list").sortable({
                tolerance: 'pointer'
            });
            $('.reorder_link').html('Save Updated Sequence');
            $('.reorder_link').attr("id", "saveReorder");
            $('#reorderHelper').slideDown('slow');
            $('.menuitem_link').attr("href", "javascript:void(0);");
            $('.menuitem_link').css("cursor", "move");
            $("#saveReorder").click(function(e) {
                if (!$("#saveReorder i").length) {
                    $(this).html('').prepend('<i class="fa fa-refresh"></i>');
                    $("ul.reorder-privacy-list").sortable('destroy');
                    $("#reorderHelper").html("Updating Category Sequence - This could take a moment. Please don't navigate away from this page.").removeClass('light_box').addClass('notice notice_error');
                    var h = [];
                    $("ul.reorder-privacy-list li").each(function() {
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