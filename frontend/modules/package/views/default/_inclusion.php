    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <?php

                use common\models\GeneralModel;
                use common\models\package\PackageIncluded;

                // Retrieve selected package inclusions
                $package_included = PackageIncluded::find()
                    ->select(['include_id', 'selection'])
                    ->where(['package_id' => $package->id, 'status' => 1])
                    ->asArray()
                    ->all();

                $selectedOptions = [];
                foreach ($package_included as $included) {
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
                                <input class="form-check-input" type="radio" name="package_included[<?= $optionValue ?>]" value="1" <?= (isset($selectedOptions[$optionValue]) && $selectedOptions[$optionValue] == 1) ? 'checked' : '' ?>>
                                <label class="form-check-label">Include</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="package_included[<?= $optionValue ?>]" value="2" <?= (isset($selectedOptions[$optionValue]) && $selectedOptions[$optionValue] == 2) ? 'checked' : '' ?>>
                                <label class="form-check-label">Exclude</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="package_included[<?= $optionValue ?>]" value="3" <?= (isset($selectedOptions[$optionValue]) && $selectedOptions[$optionValue] == 3) ? 'checked' : '' ?>>
                                <label class="form-check-label">Optional</label>
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
                <p><?= $package->package_inclusion ?></p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="itenary_text">
                <p><?= $package->package_exclusion ?></p>
            </div>
        </div>
    </div>