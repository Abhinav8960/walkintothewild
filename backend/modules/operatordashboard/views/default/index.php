<?php
$this->title = 'Operator Dashboard';
$this->params['breadcrumbs_home_url'] = '/operatordashboard';
$this->params['breadcrumbs'][] =  ['label' => 'Operator', 'url' => '#'];
$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = $this->title;
?>

<div class="card">
    <div class="card-body">
        <div class="row row-sm">
            <div class="col-lg-6 col-xl-3 col-md-6 col-12">
                <a href="/operatordashboard/safari">
                    <div class="card bg-primary-gradient text-white ">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mt-0 text-center">
                                        <h2 class="text-white mb-0">Safari Tour</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-6 col-xl-3 col-md-6 col-12">
                <a href="/operatordashboard/birding">
                    <div class="card bg-danger-gradient text-white">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mt-0 text-center">
                                        <h2 class="text-white mb-0">Birding Tour</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-6 col-xl-3 col-md-6 col-12">
                <a href="#">
                    <div class="card bg-warning-gradient text-white">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mt-0 text-center">
                                        <h2 class="text-white mb-0">Resort/Londge/Home</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>