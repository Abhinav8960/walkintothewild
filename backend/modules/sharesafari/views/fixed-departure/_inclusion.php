<?php

use common\models\GeneralModel;
use common\models\sharesafari\ShareSafariIncluded;


$share_safari_included = ShareSafariIncluded::find()
    ->select(['include_id', 'selection'])
    ->where(['share_safari_id' => $share_safari->share_safari_id, 'version' => $share_safari->version, 'status' => 1])
    ->asArray()
    ->all();
?>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <?php
            $selectedOptions = [];
            foreach ($share_safari_included as $included) {
                $selectedOptions[$included['include_id']] = $included['selection'];
            }

            // Generate radio options
            foreach (GeneralModel::packageincludeoption() as $optionValue => $optionLabel) : ?>
                <div class="row mb-2">
                    <div class="col-md-3 col-sm-4">
                        <ul class="mb-0 px-3">
                            <li><label class="control-label font_sizes"><?= $optionLabel ?> </label></li>
                        </ul>

                    </div>
                    <div class="col-md-9 col-sm-8">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <?php if ((isset($selectedOptions[$optionValue]) && $selectedOptions[$optionValue] == 1)) {
                                    echo 'Included';
                                } else if ((isset($selectedOptions[$optionValue]) && $selectedOptions[$optionValue] == 2)) {
                                    echo 'Not Included';
                                } else  if ((isset($selectedOptions[$optionValue]) && $selectedOptions[$optionValue] == 3)) {
                                    echo 'Optional';
                                } else {
                                    echo '';
                                }  ?>
                            </label>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="row mb-2">
                <div class="col-md-3 col-sm-4">
                    <ul class="mb-0 px-3">
                        <li><label class="control-label font_sizes">Meals </label></li>
                    </ul>

                </div>
                <div class="col-md-9 col-sm-8">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label d-flex gap-3">
                            <?php echo $share_safari->mealslabel; ?>

                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row inclusions">
    <div class="col-md-12 pt-3">
        <div class="itenary_text font_familydd">
            <h6 class="mb-2">Inclusion</h6>
            <p class="mb-2"><?= $share_safari->share_safari_inclusion ?></p>
        </div>
        <div class="itenary_text">
            <h6 class="mb-2">Exclusion</h6>
            <p class="mb-2"><?= $share_safari->share_safari_exclusion ?></p>
        </div>
    </div>

</div>