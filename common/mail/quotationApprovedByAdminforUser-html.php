<?php

use yii\helpers\Html;

?>
<div style="font-family: Arial, sans-serif; margin: 0; padding: 20px; background-color: #f4f4f4;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
        <table style="width: 100%; margin-bottom: 30px;">
            <tr>
                <td style="text-align: left; vertical-align: middle;">
                    <img src="<?= \Yii::$app->params['s3_endpoint'] . '/img/default_witw.png' ?>" alt="walkintothewild" style="height: 40px;">
                </td>
                <td style="text-align: right; vertical-align: middle; font-size: 14px; color: #555;">
                    <b><?= date('d M, Y') ?></b>
                </td>
            </tr>
        </table>
        <hr>
        <p style="font-size: 18px; color: #333; margin-bottom: 20px; font-style: italic;">Hi <?= Html::encode($username) ?>, get ready for your next wild adventure!</p>

        <p style="font-size: 22px; font-weight: bold; color: #333; margin-bottom: 20px;"><?= $parkname ?> <?= isset($night_stay_count) ? ' + ' . $night_stay_count . ' Nights Stay' : '' ?> <?= isset($safaris) ? ' + ' . $safaris . ' Jungle Safaris' : '' ?></p>

        <div style="background-color: #e6f7e8; padding: 20px; border-radius: 8px; margin-bottom: 30px;">
            <div style="font-size: 18px; font-weight: bold; color: #333; text-align: center; margin-bottom: 15px;">Quotation</div>
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
                <tr>
                    <td style="padding: 8px 0; font-weight: bold; width: 40%; color: #555;">Park</td>
                    <td style="padding: 8px 0; color: #555;"><?= $parkname ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; font-weight: bold; width: 40%; color: #555;">Travelers</td>
                    <td style="padding: 8px 0; color: #555;"><?= isset($travelers) ? $travelers : '' ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; font-weight: bold; width: 40%; color: #555;">Safaris</td>
                    <td style="padding: 8px 0; color: #555;"><?= isset($safaris) ? $safaris : '' ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; font-weight: bold; width: 40%; color: #555;">Stay Category</td>
                    <td style="padding: 8px 0; color: #555;"><?= isset($staycategory) ? $staycategory : '' ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; font-weight: bold; width: 40%; color: #555;">Start Date</td>
                    <td style="padding: 8px 0; color: #555;"><?= isset($start_date) ? $start_date : '' ?></td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; font-weight: bold; width: 40%; color: #555;">End Date</td>
                    <td style="padding: 8px 0; color: #555;"><?= isset($end_date) ? $end_date : '' ?></td>
                </tr>

                <?php if (isset($validity_date_time) && $validity_date_time != null) { ?>
                    <tr>
                        <td style="padding: 8px 0; font-weight: bold; width: 40%; color: #555;">Vaility Date</td>
                        <td style="padding: 8px 0; color: #555;"><?= isset($validity_date_time) ? $validity_date_time : '' ?></td>
                    </tr>
                <?php } ?>
                <?php if (isset($permit_booking_date_time) && $permit_booking_date_time != null) { ?>
                    <tr>
                        <td style="padding: 8px 0; font-weight: bold; width: 40%; color: #555;">Permit Booking Date</td>
                        <td style="padding: 8px 0; color: #555;"><?= isset($permit_booking_date_time) ? $permit_booking_date_time : '' ?></td>
                    </tr>
                <?php } ?>

            </table>

            <p style="font-size: 14px; color: #555; line-height: 1.5; margin-bottom: 20px;">
                <span style="padding: 8px 0; font-weight: bold; width: 40%; color: #555;">Additional Notes</span><br>
                <span style="padding: 8px 0; color: #555;"><?= isset($addional_notes) ? $addional_notes : '' ?></span>
            </p>

            <table style="width: 100%; font-size: 18px; font-weight: bold; color: #333; margin-bottom: 20px; border-top: 1px solid #ccc; border-bottom: 1px solid #ccc; padding-top: 15px; padding-bottom: 15px;">
                <tr>
                    <td style="text-align: left;">Amount <span style="color: #666666; font-size: 14px;">(inclusive of all taxes)</span></td>
                    <td style="text-align: right;"><?= isset($amount) ? '₹' . $amount : '' ?></td>
                </tr>
            </table>


            <div style="text-align: center; margin-bottom: 30px;">
                <table style="width: 100%; font-size: 20px; font-weight: 600; margin-bottom: 10px;">
                    <tr>
                        <td style="text-align: left;">You can pay securely using this link:</td>
                        <td style="text-align: right;">
                            <?= isset($payment_url) ? '<a style="color: #007bff; text-decoration: none; font-weight: bold; font-size: 20px;" href="' . urldecode($payment_url) . '" target="_blank">Pay Now</a>' : '' ?>
                        </td>
                    </tr>
                </table>
                <br>OR<br><br>
                <b>Scan & Pay</b><br>
                <?php if (isset($qr_code) && $qr_code): ?>
                    <img src="<?= urldecode($qr_code) ?>" alt="QR Code" style="width: 200px; height: 200px; margin-top: 15px;">
                <?php endif; ?>
            </div>
        </div>

        <div style="margin-top: 40px; padding-top: 20px; border-top: 1px solid #eee;">
            <h1 style="text-align: center; font-size: 22px; margin-bottom: 10px;">T&C</h1>
            <h2 style="text-align: center; font-size: 16px; font-weight: normal; margin-bottom: 25px; color: #555;">T&C of Mediarc Technologies Private Limited ("MEDIARC OR WALKINTOTHEWILD")</h2>

            <h3>1. General Information</h3>
            <p style="font-size: 14px; color: #555; line-height: 1.6; margin-bottom: 10px;">WALKINTOTHEWILD is operated by Mediarc Technologies Pvt. Ltd. and functions as an e-commerce operator
                providing a dedicated online marketplace for wildlife travel through <a
                    href="https://www.walkintothewild.in">www.walkintothewild.in</a>.</p>
            <p style="font-size: 14px; color: #555; line-height: 1.6; margin-bottom: 10px;">The platform connects travel agents, service providers, and prospective travellers for safari tours,
                travel packages, and related services.</p>
            <p style="font-size: 14px; color: #555; line-height: 1.6; margin-bottom: 10px;">WALKINTOTHEWILD solely operates as a technology platform and booking intermediary; all travel services
                are provided by third-party operators or service providers.</p>
            <p style="font-size: 14px; color: #555; line-height: 1.6; margin-bottom: 10px;">WALKINTOTHEWILD is not responsible for the execution, delivery, or quality of travel services offered by
                operators.</p>

            <h3>2. Booking & Payment</h3>
            <p style="font-size: 14px; color: #555; line-height: 1.6; margin-bottom: 10px;">Confirmed bookings require the first payment to be received via official modes listed on WALKINTOTHEWILD.
            </p>
            <p style="font-size: 14px; color: #555; line-height: 1.6; margin-bottom: 10px;">Full package amount, including permit fees, must be paid in advance to receive booking vouchers.</p>
            <p style="font-size: 14px; color: #555; line-height: 1.6; margin-bottom: 10px;">No cash payments or direct payments to operators are allowed. Such payments are at the customer's risk
                and not recognized by WALKINTOTHEWILD.</p>
            <p style="font-size: 14px; color: #555; line-height: 1.6; margin-bottom: 10px;">Payment should be made through legally authorized, non-cash payment channels only.</p>

            <h3>3. Cancellation & Refunds</h3>
            <p style="font-size: 14px; color: #555; line-height: 1.6; margin-bottom: 10px;">Standard Cancellation Fee: INR 5,000/- per person (non-refundable).</p>
            <p style="font-size: 14px; color: #555; line-height: 1.6; margin-bottom: 10px;">Late Payment Cancellation: Additional INR 2,000/- may apply.</p>
            <p style="font-size: 14px; color: #555; line-height: 1.6; margin-bottom: 10px;">Failure to follow the payment schedule may result in cancellation without refund.</p>
            <p style="font-size: 14px; color: #555; line-height: 1.6; margin-bottom: 10px;">Cancellation charges will be calculated on the total booking amount, even if partial payment has been
                made.</p>
            <p style="font-size: 14px; color: #555; line-height: 1.6; margin-bottom: 10px;">Refunds, if applicable, will be issued after deduction of charges, either as a credit note/voucher or to
                the original payment method, as decided by the operator in coordination with WALKINTOTHEWILD.</p>
            <p style="font-size: 14px; color: #555; line-height: 1.6; margin-bottom: 10px;">Credit notes are subject to future travel validity and applicable terms.</p>

            <h3>4. Changes, Modifications & Add-ons</h3>
            <p style="font-size: 14px; color: #555; line-height: 1.6; margin-bottom: 10px;">Any change in itinerary, inclusions, or travel dates will attract additional charges and depend on
                operator's approval.</p>

            <h3>5. Hotel & Safari Service Conditions</h3>
            <p style="font-size: 14px; color: #555; line-height: 1.6; margin-bottom: 10px;">Check-in: 12 PM | Check-out: 11 AM</p>
            <p style="font-size: 14px; color: #555; line-height: 1.6; margin-bottom: 10px;">Early/late check-in/out subject to hotel policies.</p>
            <p style="font-size: 14px; color: #555; line-height: 1.6; margin-bottom: 10px;">Hotel services, food quality, and special requests (e.g., non-smoking rooms, specific views) are not
                guaranteed.</p>
            <p style="font-size: 14px; color: #555; line-height: 1.6; margin-bottom: 10px;">WALKINTOTHEWILD/operator will not be liable for revoked hotel services.</p>
            <p style="font-size: 14px; color: #555; line-height: 1.6; margin-bottom: 10px;">Operators may change hotels due to non-operation; alternatives will be provided.</p>

            <h3>6. Safari, Sightseeing & Transport</h3>
            <p style="font-size: 14px; color: #555; line-height: 1.6; margin-bottom: 10px;">Car/driver details will be provided prior to trip start.</p>
            <p style="font-size: 14px; color: #555; line-height: 1.6; margin-bottom: 10px;">SIC (Shared Transfers): Be at pick-up spot 15-20 mins early. Delays are non-refundable.</p>
            <p style="font-size: 14px; color: #555; line-height: 1.6; margin-bottom: 10px;">Air conditioning in vehicles may not be available in hilly areas unless explicitly mentioned.</p>
            <p style="font-size: 14px; color: #555; line-height: 1.6; margin-bottom: 10px;">Transport breakdowns may cause delays; WALKINTOTHEWILD is not liable for related losses.</p>
            <p style="font-size: 14px; color: #555; line-height: 1.6; margin-bottom: 10px;">Inner Line Permits are subject to government rules; delays are possible.</p>

            <h3>7. Responsibility & Risk</h3>
            <p style="font-size: 14px; color: #555; line-height: 1.6; margin-bottom: 10px;">Customers are responsible for:</p>
            <ul>
                <li>Carrying valid photo ID (Aadhaar, Passport, DL, Voter ID).</li>
                <li>Staying informed about flight schedules, government policies, and local guidelines.</li>
                <li>Verifying vouchers within 24-48 hours of issue.</li>
                <li>Protecting personal belongings (phones, jewelry, etc.). Losses are the customer's responsibility.
                </li>
            </ul>
            <p style="font-size: 14px; color: #555; line-height: 1.6; margin-bottom: 10px;">Any sightseeing/safari missed due to delays by the customer or extended time at stops will not be
                compensated.</p>

            <h3>8. Force Majeure & Unforeseen Events</h3>
            <p style="font-size: 14px; color: #555; line-height: 1.6; margin-bottom: 10px;">WALKINTOTHEWILD is not liable for cancellations or service disruptions due to:</p>
            <ul>
                <li>Riots, strikes, curfews, natural disasters, terrorism, wars, adverse weather, or similar force
                    majeure conditions.</li>
            </ul>
            <p style="font-size: 14px; color: #555; line-height: 1.6; margin-bottom: 10px;">If attractions are closed due to such circumstances, efforts will be made for partial refunds, but there
                is no obligation.</p>

            <h3>9. Operator Responsibilities</h3>
            <p style="font-size: 14px; color: #555; line-height: 1.6; margin-bottom: 10px;">The following are the sole responsibilities of the Operator:</p>
            <ol type="a">
                <li>Deliver all services as per committed itinerary.</li>
                <li>Ensure clear and timely communication of any changes.</li>
                <li>Issue tax invoices and deposit GST as per Indian laws.</li>
                <li>Comply with all laws related to travel, taxation, foreign exchange, and consumer protection.</li>
            </ol>
            <p style="font-size: 14px; color: #555; line-height: 1.6; margin-bottom: 10px;">Note: WALKINTOTHEWILD shall not mediate or be held liable for any customer grievances arising from the
                operator's failure to meet the above responsibilities.</p>

            <h3>10. Additional Conditions</h3>
            <p style="font-size: 14px; color: #555; line-height: 1.6; margin-bottom: 10px;">Customers must provide PAN, Aadhaar, or required documents for compliance. Failure to do so may attract
                penalties.</p>
            <p style="font-size: 14px; color: #555; line-height: 1.6; margin-bottom: 10px;">Customers must disclose non-Indian nationalities at the time of booking. Failure may lead to denial of
                services with no refund.</p>
            <p style="font-size: 14px; color: #555; line-height: 1.6; margin-bottom: 10px;">In case of currency fluctuations or tax revisions, the tour price may be revised.</p>

            <h3>11. Meals & Extras</h3>
            <p style="font-size: 14px; color: #555; line-height: 1.6; margin-bottom: 10px;">For meals included as part of sightseeing, menu is pre-set; specific meal choices may not be available.
            </p>
            <p style="font-size: 14px; color: #555; line-height: 1.6; margin-bottom: 10px;">Expenses of personal nature (laundry, minibars, calls, etc.) are not covered and must be borne by the
                customer.</p>

            <h3>12. Contact & Support</h3>
            <p style="font-size: 14px; color: #555; line-height: 1.6; margin-bottom: 10px;">For any issues, immediately contact your assigned operator or write to <a
                    href="mailto:support@walkintothewild.in">support@walkintothewild.in</a></p>
            <p style="font-size: 14px; color: #555; line-height: 1.6; margin-bottom: 10px;">If an operator asks for a direct payment, report it immediately.</p>
        </div>

        <div style="text-align: center; margin-top: 15px; font-size: 14px; color: #555; padding: 15px 0px; border-top: 1px solid #eee;">
            If you have any questions, feel free to message us at <a style="color: #007bff; text-decoration: none;" href="mailto:support@walkintothewild.in">support@walkintothewild.in</a>
        </div>
        <div style="text-align: center; font-size: 12px; color: #777; margin-top: 15px;">
            B1/639, Janakpuri, New Delhi,<br>Delhi 110058
        </div>
        <div style="text-align: center; font-size: 12px; color: #777; margin-top: 30px; border-top: 1px solid #eee; padding-top: 15px;">
            <a style="color: #007bff; text-decoration: none;" href="https://www.walkintothewild.in/terms-of-use" target="_blank">Terms of use</a> | <a style="color: #007bff; text-decoration: none;" href="https://www.walkintothewild.in/privacy-policy" target="_blank">Privacy</a>
        </div>
    </div>
</div>