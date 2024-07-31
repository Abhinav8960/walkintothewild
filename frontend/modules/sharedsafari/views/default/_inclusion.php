    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <?php

                use common\models\GeneralModel;
                use common\models\sharesafari\ShareSafariIncluded;

                // Retrieve selected package inclusions
                $share_safari_included = ShareSafariIncluded::find()
                    ->select(['include_id', 'selection'])
                    ->where(['share_safari_id' => $share_safari->id, 'status' => 1])
                    ->asArray()
                    ->all();

                $selectedOptions = [];
                foreach ($share_safari_included as $included) {
                    $selectedOptions[$included['include_id']] = $included['selection'];
                }

                // Generate radio options
                foreach (GeneralModel::packageincludeoption() as $optionValue => $optionLabel) : ?>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <label class="control-label font_sizes"><?= $optionLabel ?></label>
                        </div>
                        <div class="col-sm-9">
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <?php if ((isset($selectedOptions[$optionValue]) && $selectedOptions[$optionValue] == 1)) {
                                        echo 'Include';
                                    } elseif ((isset($selectedOptions[$optionValue]) && $selectedOptions[$optionValue] == 2)) {
                                        echo 'Exclude';
                                    } else if ((isset($selectedOptions[$optionValue]) && $selectedOptions[$optionValue] == 3)) {
                                        echo 'Optional';
                                    } else {
                                        echo 'N/A';
                                    } ?>
                                </label>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="itenary_text">
                <p><?= $share_safari->share_safari_inclusion ?></p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="itenary_text">
                <p><?= $share_safari->share_safari_exclusion ?></p>
            </div>
        </div>
    </div>