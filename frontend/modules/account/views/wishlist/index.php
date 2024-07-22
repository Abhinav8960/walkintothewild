<?php
$this->title = 'Your Wishlist';

?>

<div class="container mt-5 mb-5">
    <div class="card">
        <div class="row mb-5">
            <div class="col-md-12 m-3 mt-2">
                <h5>Wishlist</h5>
            </div>
            <div class="col-md-12">
                <ul class="nav nav-pills mb-3 m-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-packages-tab" data-bs-toggle="pill" data-bs-target="#pills-packages" type="button" role="tab" aria-controls="pills-packages" aria-selected="true">Packages </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-shared-safari-tab" data-bs-toggle="pill" data-bs-target="#pills-shared-safari" type="button" role="tab" aria-controls="pills-shared-safari" aria-selected="false">Shared Safaris</button>
                    </li>
                </ul>

                <div class="tab-content m-3" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-packages" role="tabpanel" aria-labelledby="pills-packages-tab">
                        No Packages found in wishlist
                    </div>
                    <div class="tab-pane fade" id="pills-shared-safari" role="tabpanel" aria-labelledby="pills-shared-safari-tab">
                        No Shared Safari found in wishlist
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>