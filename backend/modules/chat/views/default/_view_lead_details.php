<?php

if (!empty($lead)) {
?>

    <div class="d-flex justify-content-center m-2">
        <div class="ItineraryQuotationarea">
            <div class="topTitle pb-3">
                <h3 class="text-center"><?= $lead->name ?></h3>
            </div>
            <div class="discriptionsCenter">
                <p class="mb-1"><span>Park:</span> <b><?= $lead->park->title ?? '' ?></b> </p>
                <p class="mb-1"><span>Safaris:</span><b> <?= $lead->safaris ?? '' ?></b></p>
                <p class="mb-1"><span>Travelers:</span><b> <?= $lead->travelers ?? '' ?></b></p>
                <p class="mb-1"><span>Stay Category:</span> <b><?= $lead->staycatgory->title ?? '' ?></b></p>
                <p class="mb-1"><span>Start Date:</span><b><?= !empty($lead->from_date) ? date('M d, Y', strtotime($lead->from_date)) : '' ?></b></p>
                <p class="mb-1"><span>End Date:</span><b><?= !empty($lead->to_date) ? date('M d, Y', strtotime($lead->to_date)) : '' ?></b></p>
            </div>
            <div class="recievedTime d-flex justify-content-end">
                <span><?= date('Y-m-d H:i', $lead->created_at) ?></span>
            </div>
        </div>
    </div>

<?php
}
?>