<?php

use business\assets\AppAsset;
use common\models\GeneralModel;

$webasset = $this->assetManager->getBundle('\business\assets\PartnerAppAsset');
$this->params['baseurl'] = $webasset->baseUrl;
AppAsset::register($this);

$this->title = 'Fixed Departure Chat';
?>
<div class="wrapper_inner">
    <div class="row">
        <div class="col-lg-5">
            <div class="be-scroller">
                <?php if ($fd = $chat_model->fixedDeparture) { ?>
                    <div class="details-packages mb-3">
                        <table class="table w-100 border-0 border_o">
                            <thead class="thead-details">
                                <tr>
                                    <th style="background-color: #C4E3BD !important;">
                                        <p>Fixed Departure</p>
                                    </th>
                                    <th style="background-color: #C4E3BD !important;">
                                        <p><?= $fd->share_safari_title ?></p>
                                    </th>
                                </tr>

                            </thead>
                            <tbody class="tbody-leads py-3">
                                <tr>
                                    <td>Display Image</td>
                                    <td>
                                        <img src="<?= isset($fd->sharedimagepath) ? $fd->sharedimagepath : $this->params['baseurl'] . '/images/NewBanner_big.png' ?>" alt="" width="100%">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Safari Plan</td>
                                    <td>
                                        <p><?= $fd->safari_plan ?></p>
                                    </td>
                                </tr>


                                <tr>
                                    <td>Cut Off Date</td>
                                    <td>
                                        <p><?= $fd->cut_off_date ?></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Start Date</td>
                                    <td>
                                        <p><?= $fd->start_date ?></p>
                                    </td>
                                </tr>

                                <tr>
                                    <td>End Date</td>
                                    <td>
                                        <p><?= $fd->end_date ?></p>
                                    </td>
                                </tr>

                                <tr>
                                    <td>No of Safari</td>
                                    <td>
                                        <p><?= $fd->no_of_safari ?></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Price</td>
                                    <td>
                                        <p><img src="<?= $this->params['baseurl'] ?>/images/rupees.png" alt="" width="15px" class="me-1 mb-1"><?= GeneralModel::number_format_indian($fd->cost_per_person) ?></p>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="chats_wrapper">
                <?= $this->render('_chat', ['chat' => $chat_model]) ?>
                <div class="row">
                    <?= $this->render('_send_message', ['model' => $chat_message_model]) ?>
                </div>
            </div>
        </div>
    </div>
</div>