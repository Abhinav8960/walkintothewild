<div class="row">
    <div class="col-md-4">
        <div class="text-box">
            <span class="form-label d-inline-block pe-2">Title: </span><b><?= $model->title ?></b>
        </div>
    </div>
    <div class="col-md-4">
        <div class="text-box">
            <span class="form-label d-inline-block pe-2">Safari Cost: </span><b><?= $model->avg_safari_price ?></b>
        </div>
    </div>
    <div class="col-md-4">
        <div class="text-box">
            <span class="form-label d-inline-block pe-2">Status: </span><b><?= $model->status ? 'Active' : 'Suspend' ?></b>
        </div>
    </div>
</div>

<br>

<div class="row">
    <div class="col-md-4">
        <div class="text-box">
            <span class="form-label d-inline-block pe-2">Country: </span><b><?= $model->country->country_name ?></b>
        </div>
    </div>
    <div class="col-md-4">
        <div class="text-box">
            <span class="form-label d-inline-block pe-2">State: </span><b><?= $model->state->state_name ?></b>
        </div>
    </div>
    <div class="col-md-4">
        <div class="text-box">
            <span class="form-label d-inline-block pe-2">City: </span><b><?= $model->city->city_name ?></b>
        </div>
    </div>
</div>

<br>

<div class="row">
    <div class="col-md-4">
        <div class="text-box">
            <span class="form-label d-inline-block pe-2">Location: </span><b>
                <?= ($model->location->title ?? '') ?>
            </b>
        </div>
    </div>

    <div class="col-md-8">
        <div class="text-box">
            <span class="form-label d-inline-block pe-2">Nearest Landmark: </span><b>
                <?= ($model->location->title ?? '') . ', ' . ($model->railwaystation->title ?? '') . ', ' . ($model->airport->name ?? '') ?>
            </b>
        </div>
    </div>
</div>
<br>

<div class="row">
    <div class="col-md-12">
        <div class="text-box">
            <span class="form-label d-inline-block pe-2">Short Description: </span><b>
                <?= ($model->short_description) ?>
            </b>
        </div>
    </div>
</div>