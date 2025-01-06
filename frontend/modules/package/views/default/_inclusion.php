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
                            <?php echo $package->mealslabel; ?>
                                <!-- <input type="checkbox" id="breakfast_included" value="1" <?= ($package->breakfast_included == 1) ? 'checked' : '' ?> disabled> Breakfast<br>
                                <input type="checkbox" id="lunch_included" value="1" <?= ($package->lunch_included == 1) ? 'checked' : '' ?> disabled> Lunch<br>
                                <input type="checkbox" id="dinner_included" value="1" <?= ($package->dinner_included == 1) ? 'checked' : '' ?> disabled> Dinner<br>
                                <input type="checkbox" id="meal_not_included" value="1" <?= ($package->meal_not_included == 1) ? 'checked' : '' ?> disabled> Meal Not Included<br> -->
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
                <p class="mb-2"><?= $package->package_inclusion ?></p>
            </div>
            <div class="itenary_text">
                <p class="mb-2"><?= $package->package_exclusion ?></p>
            </div>
        </div>

    </div>