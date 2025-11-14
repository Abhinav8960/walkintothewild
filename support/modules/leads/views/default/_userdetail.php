<?php

use yii\helpers\Html;

?>
<div class="table-wrapper remove-css mb-4">
    <div class="table-responsive">
        <div class="min-width-table">
            <div id="w0" class="table-responsive">
                <table class="table tablecustoms table-striped align-middle w-100">
                    <thead>
                        <tr>
                            <th style="width: 1%;">#</th>
                            <th style="width: 5%;">User Name</th>
                            <th style="width: 5%;">Phone No.</th>
                            <th style="width: 5%;">Travel Interest</th>
                            <th style="width: 2%;">Safaris</th>
                            <th style="width: 2%;">Travelers</th>
                            <th style="width: 2%;">Accomodation</th>
                            <th style="width: 3%;">User Notes</th>
                            <th style="width: 3%;">Travel Date looking For</th>
                            <th style="width: 3%;">Lead Received Date</th>
                            <th style="width: 3%;">Trip Budget</th>
                            <th style="width: 3%;">Planning Type</th>
                            <th style="width: 10%;">Payment Info</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr data-key="840">
                            <td>1</td>
                            <td><?php
                                if ($user = $model->user) {
                                    $name = $user->name ?? '';
                                    $imageUrl = $user->profile_display_image ?:  $this->params['baseurl'] . '/images/dpmain.png';
                                    echo
                                    Html::img($imageUrl, [
                                        'class' => "rounded profile-picture",
                                        'style' => "width:28px;"
                                    ]) . ' ' . Html::encode($name);
                                }
                                ?></td>
                            <td><?= $model->phone ?></td>
                            <td><?= $model->displayLabel ?></td>
                            <td><?= !empty($model->safaris) ? $model->safaris : ''; ?></td>
                            <td><?= !empty($model->travelers) ? $model->travelers : '' ?></td>
                            <td><?= !empty($model->staycatgory) ? $model->staycatgory->title : '' ?></td>
                            <td style="text-align: left;"><?= !empty($model->user_notes) ? $model->user_notes : '' ?></td>
                            <td style="text-align: left;">
                                <?php
                                $str = date('d M, Y', strtotime($model->from_date));
                                if (!empty($model->to_date)) {
                                    $str .= '- ' . date('d M, Y', strtotime($model->to_date));
                                }
                                echo $str;
                                ?>
                            </td>
                            <td style="text-align: left;"><?= date('d M, Y h:i A', $model->created_at) ?></td>
                            <td style="text-align: left;"><?= $model->tripBudget ?></td>
                            <td style="text-align: left;"><?= $model->planningType ?></td>
                            <td>
                                <div class="paymentInfoDetail">
                                    <?php
                                    $str = '';
                                    if ($model->is_payment_received) {
                                        $str .= '<span class="payRece notRece d-inline-block mb-1">Payment Received</span>';
                                        if (!empty($model->transaction_datetime)) {
                                            $str .= '<br><b>Payment Date</b>: ' . date('d M, Y H:i A', strtotime($model->transaction_datetime));
                                        }
                                        if (!empty($model->transaction_id)) {
                                            $str .= '<br><b>Transaction Id</b>: ' . $model->transaction_id;
                                        }
                                        if (!empty($model->booked_operator_id)) {
                                            $str .= '<br><b>Operator Booked</b>: ' . $model->bookedpartner->business_name;
                                        }
                                    } else {
                                        $str .= '<span class="payRece notRece d-inline-block mb-1">Payment Not Received</span>';
                                    }

                                    // $str .= '<br><b><a style="color: black !important;" href="/log/transaction?TransactionSearch[lead_id]=' . $model->id . '" target="_blank">All Transaction</b>: </a>';
                                    echo $str;

                                    ?>
                                    <!-- <a href="" class="payRece d-inline-block mb-1">Payment Received</a>
                                    <p class="mt-1 mb-1"><span class="bolder_font">Payment Date:</span> 03 Jul, 2025 13:24 PM</p>
                                    <p class="mt-0"><span class="bolder_font">Transaction Id:</span> 01DDG45</p> -->
                                </div>
                            </td>
                        </tr>

                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>