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
                  <div class="row ">
                      <div class="col-sm-4 col-md-3">
                          <ul class="px-3">
                              <li><label class="control-label font_sizes"><?= $optionLabel ?></label></li>
                          </ul>

                      </div>
                      <div class="col-sm-8 col-md-9">
                          <div class="form-check form-check-inline">
                              <label class="form-check-label">
                                  <?php if ((isset($selectedOptions[$optionValue]) && $selectedOptions[$optionValue] == 1)) {
                                        echo 'Include';
                                    } elseif ((isset($selectedOptions[$optionValue]) && $selectedOptions[$optionValue] == 2)) {
                                        echo 'Not Include';
                                    } else if ((isset($selectedOptions[$optionValue]) && $selectedOptions[$optionValue] == 3)) {
                                        echo 'Optional';
                                    } else {
                                        echo '';
                                    } ?>
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

                              <!-- <input type="checkbox" id="breakfast_included" value="1" <?= ($share_safari->breakfast_included == 1) ? 'checked' : '' ?> disabled> Breakfast<br>
                              
                                  <input type="checkbox" id="lunch_included" value="1" <?= ($share_safari->lunch_included == 1) ? 'checked' : '' ?> disabled> Lunch<br>
                            
                                  <input type="checkbox" id="dinner_included" value="1" <?= ($share_safari->dinner_included == 1) ? 'checked' : '' ?> disabled> Dinner<br>
                             
                                  <input type="checkbox" id="meal_not_included" value="1" <?= ($share_safari->meal_not_included == 1) ? 'checked' : '' ?> disabled> Meal Not Included<br> -->

                          </label>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <div class="row">
      <div class="col-md-12 inclusions">
          <div class="itenary_text">
              <p><?= $share_safari->share_safari_inclusion ?></p>
          </div>
      </div>
      <div class="col-md-12 ">
          <div class="itenary_text inclusions">
              <p><?= $share_safari->share_safari_exclusion ?></p>
          </div>
      </div>
  </div>