<?php

use yii\helpers\Html;

?>
<div class="verify-email">
    <p>Hi <?= Html::encode($username) ?>,</p>
    <p>You have received a new quote request for <?= $parkname ?>,. Please check your inbox to review the details and respond promptly. </p>
    <p>Quote</p>
    <br>
    <table style="width: 100%; border-collapse: collapse;">
        <tbody>
            <tr>
                <th style="background-color: #f0f0f0; padding: 10px; border: 1px solid #ddd; text-align: left;">Park</th>
                <td style="padding: 10px; border: 1px solid #ddd;"><?= isset($parkname) ? $parkname : '' ?></td>
            </tr>
            <tr>
                <th style="background-color: #f0f0f0; padding: 10px; border: 1px solid #ddd; text-align: left;">Travelers</th>
                <td style="padding: 10px; border: 1px solid #ddd;"><?= isset($travelers) ? $travelers : '' ?></td>
            </tr>
            <tr>
                <th style="background-color: #f0f0f0; padding: 10px; border: 1px solid #ddd; text-align: left;">Safaris</th>
                <td style="padding: 10px; border: 1px solid #ddd;"><?= isset($safaris) ? $safaris : '' ?></td>
            </tr>
            <tr>
                <th style="background-color: #f0f0f0; padding: 10px; border: 1px solid #ddd; text-align: left;">Start Date</th>
                <td style="padding: 10px; border: 1px solid #ddd;"><?= isset($start_date) ? $start_date : '' ?></td>
            </tr>
            <tr>
                <th style="background-color: #f0f0f0; padding: 10px; border: 1px solid #ddd; text-align: left;">End Date</th>
                <td style="padding: 10px; border: 1px solid #ddd;"><?= isset($end_date) ? $end_date : '' ?></td>
            </tr>
            <tr>
                <th style="background-color: #f0f0f0; padding: 10px; border: 1px solid #ddd; text-align: left;">Stay Category</th>
                <td style="padding: 10px; border: 1px solid #ddd;"><?= isset($staycategory) ? $staycategory : '' ?></td>
            </tr>
            <tr>
                <th style="background-color: #f0f0f0; padding: 10px; border: 1px solid #ddd; text-align: left;">Additional Notes</th>
                <td style="padding: 10px; border: 1px solid #ddd;"><?= isset($addional_notes) ? $addional_notes : '' ?></td>
            </tr>
            <tr>
                <th style="background-color: #f0f0f0; padding: 10px; border: 1px solid #ddd; text-align: left;">Quote Amount</th>
                <td style="padding: 10px; border: 1px solid #ddd;"><?= isset($amount) ? $amount : '' ?></td>
            </tr>
        </tbody>
    </table>
    <br>
    <table cellpadding="2"  style="width: 100%; border-collapse: collapse;margin-top: 20px;">
        <tbody>
            <tr>
                <td bgcolor="#ffffff" style="background: #ffffff;border: 1px solid #999999;padding: 0.04cm 0cm;">
                    <p style="line-height: 115%;padding: 0px 5px;text-align: justify;margin-bottom: 0.25cm;background: transparent;"><span style="color: rgb(30, 137, 134);"><strong>T&amp;C of Walkintothewild Technologies Private Limited (&ldquo;MEDIARC or WALKINTOTHEWILD&rdquo;)</strong></span></p>
                </td>
            </tr>
            <tr>
                <td bgcolor="#ffffff" style="background: #ffffff;border: 1px solid #999999;padding: 0.04cm 0cm;">
                    <p style="line-height: 115%;padding: 0px 5px;text-align: justify;margin-bottom: 0.25cm;background: transparent;">Cancellation Service Charge: INR 5,000/- per person (Non-refundable Standard Cancellation)</p>
                </td>
            </tr>
            <tr>
                <td bgcolor="#ffffff" style="background: #ffffff;border: 1px solid #999999;padding: 0.04cm 0cm;">
                    <ul>
                        <li>
                            <p style="line-height: 115%;padding: 0px 5px;text-align: justify;background: transparent;margin-bottom: 0cm;">WALKINTOTHEWILD is inter alia engaged in the business of an e-commerce operator and operates an online platform through its website&nbsp;<span style="color: rgb(5, 99, 193);"><u><a href="http://www.walkintothewild.in/" target="_new">www.walkintothewild.in</a></u></span>, which serves as a dedicated marketplace for wildlife travel by enabling travel agents and service providers to list and promote safari tours, travel packages, and related hospitality offerings, connect with prospective travellers seeking wildlife experiences, and enhance their visibility and customer outreach in the global wildlife tourism segment.&nbsp;</p>
                        </li>
                        <li>
                            <p style="line-height: 115%;padding: 0px 5px;text-align: justify;background: transparent;margin-bottom: 0cm;">WALKINTOTHEWILD functions solely as a technology platform and marketplace intermediary for the facilitation of travel service bookings. The responsibility for the provision, execution, and performance of the services rests exclusively with the respective operators and/or Service Provider. WALKINTOTHEWILD shall bear no liability in this regard.</p>
                        </li>
                        <li>
                            <p style="line-height: 115%;padding: 0px 5px;text-align: justify;background: transparent;margin-right: 0cm;margin-bottom: 0.01cm;">the Operator is in the business of providing travel-related services specifically in connection with wildlife and safari tourism, including but not limited to arrangements for land transport, flights, guided safari activities, jungle lodges or hotels, meals, and other ancillary services incidental to wildlife travel;</p>
                        </li>
                        <li>
                            <p style="line-height: 115%;padding: 0px 5px;text-align: justify;background: transparent;margin-bottom: 0cm;">If the booking is cancelled due to delayed or non-payment as per the agreed terms, an additional fee of INR 2,000 may be applicable (if applicable).</p>
                        </li>
                        <li>
                            <p style="line-height: 115%;padding: 0px 5px;text-align: justify;background: transparent;margin-bottom: 0cm;">The customers are required to adhere strictly to the agreed payment schedule. In the event of non-compliance, WALKINTOTHEWILD may, at its sole and absolute discretion, grant an extension of up to three-to-five (3-5) business days, provided the customer submits a specific written request within the original payment timeline</p>
                        </li>
                        <li>
                            <p style="line-height: 115%;padding: 0px 5px;text-align: justify;background: transparent;margin-bottom: 0cm;">In case of non-compliance of payment terms, WALKINTOTHEWILD reserves the right to cancel the booking and in such case, no refund shall be allowed.</p>
                        </li>
                        <li>
                            <p style="line-height: 115%;padding: 0px 5px;text-align: justify;background: transparent;margin-bottom: 0cm;">Customers are required to remit the full package amount exclusively through legally authorized, non-cash payment channels permitted by WALKINTOTHEWILD. Any attempt to make payments in cash or through unauthorized means, including direct transactions with the Operator, is strictly prohibited. Customers who disregard this policy shall forfeit any right to dispute or raise claims regarding the mode of payment utilized.</p>
                        </li>
                        <li>
                            <p style="line-height: 115%;padding: 0px 5px;text-align: justify;background: transparent;margin-bottom: 0cm;">WALKINTOTHEWILD does not endorse or authorize direct payments to the operators under any circumstances. Should your operator request such a payment, you are strongly advised to report the matter immediately to the customer care&nbsp;<span style="color: rgb(5, 99, 193);"><u><a href="mailto:support@mediarc.in"><em><strong>support@walkintothewild.in</strong></em></a></u></span>Any direct payment made to an operator will be entirely at your own risk, and WALKINTOTHEWILD shall bear no responsibility of any kind of services offered and agreed while confirming the booking.</p>
                        </li>
                        <li>
                            <p style="line-height: 115%;padding: 0px 5px;text-align: justify;background: transparent;margin-bottom: 0cm;">Any amendments or addition to the package including changes to travel dates, inclusions or itinerary will incur an additional cost to the customer. Such changes will be subject to the cancellation policy of the original package and the customer shall bear any associated costs arising from the modification.</p>
                        </li>
                        
                        <li>
                            <p style="line-height: 115%;padding: 0px 5px;text-align: justify;background: transparent;margin-bottom: 0cm;">WALKINTOTHEWILD does not encourage modifications to the bookings once confirmed online. However, any changes related to postponement or rescheduling of a booked package are subject to the sole discretion of the operator and are permitted only under certain circumstances. WALKINTOTHEWILD shall not be held liable for any consequences arising from changes to the original itinerary initiated by the operator. Such changes are subject to the mutual consent between the operator and the customers.</p>
                        </li>
                        <li>
                            <p style="line-height: 115%;padding: 0px 5px;text-align: justify;background: transparent;margin-bottom: 0cm;">The customer shall receive a refund after the deduction of all applicable charges, in accordance with the refund policies of both WALKINTOTHEWILD and the respective operator.</p>
                        </li>
                        <li>
                            <p style="line-height: 115%;padding: 0px 5px;text-align: justify;background: transparent;margin-bottom: 0cm;">Cancellation amount/charges will be calculated as per total booking amount, irrespective of whether full booking amount has been paid or not.</p>
                        </li>
                        <li>
                            <p style="line-height: 115%;padding: 0px 5px;text-align: justify;background: transparent;margin-bottom: 0cm;">100% of the entire package amount including but not limited to the permit fee must be paid in advance for the issuance of booking vouchers. In case there is any incremental fluctuation in price by the time the payment is received, the revised price shall be borne by the customer, and the package will be modified accordingly.</p>
                        </li>
                        <li>
                            <p style="line-height: 115%;padding: 0px 5px;text-align: justify;background: transparent;margin-bottom: 0cm;">Any changes to the itinerary after booking, whether additions or exclusions, shall be at the sole discretion of the Customer, in mutual agreement with their Operator. Accordingly, any disputes arising from such changes, including but not limited to refund claims, shall be the responsibility of the Operator. WALKINTOTHEWILD shall bear no liability in this regard.</p>
                        </li>
                        <li>
                            <p style="line-height: 115%;padding: 0px 5px;text-align: justify;background: transparent;margin-bottom: 0cm;">Please note that all special requests, such as early check-in, late check-out, smoking or non-smoking rooms, specific views or floors, king or twin beds, adjoining and/or interconnecting rooms&mdash;are strictly subject to availability upon arrival and cannot be guaranteed in advance.</p>
                        </li>
                        <li>
                            <p style="line-height: 115%;padding: 0px 5px;text-align: justify;background: transparent;margin-bottom: 0cm;">Cost of expenses of personal nature at the place of stay, such as laundry, telephone calls, room service, alcoholic beverages, mini bar etc. not mentioned in the inclusions will have to be borne by the customer.</p>
                        </li>
                        <li>
                            <p style="line-height: 115%;padding: 0px 5px;text-align: justify;background: transparent;margin-bottom: 0cm;">For SIC (i.e. shared) transfers, please reach SIC pick up spot at least 15-20 minutes prior to actual timing, any delay by customer in reporting on time may lead to loss of service and will not be refundable by WALKINTOTHEWILD or its operator.</p>
                        </li>
                        <li>
                            <p style="line-height: 115%;padding: 0px 5px;text-align: justify;background: transparent;margin-bottom: 0cm;">The itinerary is structured to ensure that all sightseeing activities including safari are covered within the stipulated time frame and can be enjoyed sufficiently. Customers are strongly advised to follow the guidance of the assigned operator or driver and manage their time accordingly. Should any sightseeing spots / Safaris be missed due to extended stays at certain attractions beyond the advised time, neither the driver, operator, nor WALKINTOTHEWILD shall be held responsible.</p>
                        </li>
                        <li>
                            <p style="line-height: 115%;padding: 0px 5px;text-align: justify;background: transparent;margin-bottom: 0cm;">Customers can&rsquo;t change the itinerary during the trip unless the same has been pre-informed and assented by the operator or the WALKINTOTHEWILD.</p>
                        </li>
                        <li>
                            <p style="line-height: 115%;padding: 0px 5px;text-align: justify;background: transparent;margin-bottom: 0cm;">WALKINTOTHEWILD can&rsquo;t guarantee hotel services or food quality. If you face any issues, please let your operator know right away so that they can help fix the problem quickly.</p>
                        </li>
                        <li>
                            <p style="line-height: 115%;padding: 0px 5px;text-align: justify;background: transparent;margin-bottom: 0cm;">WALKINTOTHEWILD/operator do not take guarantee for any services revoked from the hotel without prior notice.</p>
                        </li>
                        <li>
                            <p style="line-height: 115%;padding: 0px 5px;text-align: justify;background: transparent;margin-bottom: 0cm;">WALKINTOTHEWILD shall not be liable for any losses incurred by the customers due to violation of rules of local authority or the government.</p>
                        </li>
                        <li>
                            <p style="line-height: 115%;padding: 0px 5px;text-align: justify;background: transparent;margin-bottom: 0cm;">In case on any currency fluctuations or amendment in local Government taxes, WALKINTOTHEWILD reserves the right to adjust the tour price accordingly.</p>
                        </li>
                        <li>
                            <p style="line-height: 115%;padding: 0px 5px;text-align: justify;background: transparent;margin-bottom: 0cm;">For meals included in the package as part of sightseeing/activity, the menu is preset and specific choice of meal may not be available.</p>
                        </li>
                        <li>
                            <p style="line-height: 115%;padding: 0px 5px;text-align: justify;background: transparent;margin-bottom: 0cm;">WALKINTOTHEWILD and/or the Operator shall not be held responsible for the safekeeping of personal belongings during the trip. Any loss or damage to valuable items such as mobile phones, tablets, jewelry, or similar possessions shall be entirely at the customer&rsquo;s own risk and responsibility.</p>
                        </li>
                        <li>
                            <p style="line-height: 115%;padding: 0px 5px;text-align: justify;background: transparent;margin-bottom: 0cm;">Travelers are required to thoroughly verify all vouchers issued by the Operators in connection with their booking. Any discrepancies must be reported within 24-48 hours from the time of receipt. Failure to do so may result in limited scope for resolution.</p>
                        </li>
                        <li>
                            <p style="line-height: 115%;padding: 0px 5px;text-align: justify;background: transparent;margin-bottom: 0cm;"><strong>Force Majeure</strong>: In the event of force majeure circumstances, such as curfews, riots, or other unforeseeable events, WALKINTOTHEWILD shall not be held liable for any resulting losses. &ldquo;Force majeure&rdquo; refers to any event which WALKINTOTHEWILD or the operator could not, even with due care, anticipate or prevent. This includes, but is not limited to: war or threats of war, riots, civil unrest, industrial disputes, terrorist acts, natural or nuclear disasters, fires, acts of God, adverse weather conditions, and other similar unforeseen events.</p>
                        </li>
                        <li>
                            <p style="line-height: 115%;padding: 0px 5px;text-align: justify;background: transparent;margin-bottom: 0cm;">In the event that local attractions are closed due to maintenance, weather conditions, government orders, strikes, curfews, natural calamities, or any other unforeseen circumstances, WALKINTOTHEWILD and/or the Operator will make best efforts to reimburse the customer an appropriate amount, provided a refund is possible. However, WALKINTOTHEWILD and its Operators are under no obligation to do so and shall not be held liable in such cases.</p>
                        </li>
                        <li>
                            <p style="line-height: 115%;padding: 0px 5px;text-align: justify;background: transparent;margin-bottom: 0.49cm;"><u><strong>Responsibilities of the Operators:</strong></u></p>
                        </li>
                    </ul>
                    <p style="line-height: 115%;padding: 0px 5px;text-align: justify;background: transparent;margin-left: 2.16cm;margin-bottom: 0.42cm;">The Customer hereby acknowledges that the following responsibilities lie solely with the Operator. In the event of any failure by the operator to fulfill these obligations, WALKINTOTHEWILD shall not be held liable in any manner. Accordingly, WALKINTOTHEWILD shall not be obligated to address or resolve any related concerns raised by the Customer.&nbsp;<br><strong>a.</strong> The Operator shall deliver all services strictly in accordance with the itinerary as committed to the customer and shall ensure timely and transparent communication of any change(s), if any, in the itinerary or services.</p>
                    <p style="line-height: 115%;padding: 0px 5px;text-align: justify;background: transparent;margin-left: 2.16cm;margin-bottom: 0.42cm;"><strong>b.</strong> The Operator shall timely discharge all applicable statutory dues and taxes, including Goods and Services Tax, arising from the sale or provision of the travel package or any part thereof.</p>
                    <p style="line-height: 115%;padding: 0px 5px;text-align: justify;background: transparent;margin-left: 2.16cm;margin-bottom: 0.42cm;"><strong>c.</strong> The Operator shall issue a tax invoice to the customer for the full package value in accordance with Applicable Laws and deposit GST to the appropriate authority of Government of India.</p>
                    <p style="line-height: 115%;padding: 0px 5px;text-align: justify;background: transparent;margin-left: 2.16cm;margin-bottom: 0.42cm;"><strong>d.</strong> The Operator shall at all times comply with all Applicable Laws, rules, regulations, and guidelines, including but not limited to those relating to taxation, foreign exchange, travel services, and consumer protection</p>
                    <ul>
                        <li>
                            <p style="line-height: 115%;padding: 0px 5px;text-align: justify;background: transparent;margin-bottom: 0cm;">With regard to the operator&rsquo;s responsibility depicted above, the customer hereby acknowledge that it shall be his/her responsibility to provide required documents like PAN, Aadhaar etc. as may be required from time to time. Failure to do so by the customer is subject to penalty imposed by the government and the operator over and above the T&amp;C of cancellation.</p>
                        </li>
                        <li>
                            <p style="line-height: 115%;padding: 0px 5px;text-align: justify;background: transparent;margin-bottom: 0cm;">In light of the dynamic external environment, it is the sole responsibility of the customer to stay informed about all relevant guidelines, flight schedule changes, and compliance requirements as per prevailing government norms and policies. Customer must independently monitor such updates and ensure full adherence. WALKINTOTHEWILD shall bear no responsibility for any failure or oversight on the part of the customers.</p>
                        </li>
                        <li>
                            <p style="line-height: 115%;padding: 0px 5px;text-align: justify;background: transparent;margin-bottom: 0.49cm;">You acknowledge and understand that refunds may be issued in the form of a credit note or voucher, which can be used for future travel in accordance with the applicable terms, or may be provided. The mode of refund (whether credit note or original payment method) is at the discretion of the operator, in coordination with WALKINTOTHEWILD, as applicable.</p>
                        </li>
                    </ul>
                    <p style="line-height: 115%;padding: 0px 5px;text-align: justify;margin-bottom: 0.25cm;background: transparent;margin-left: 1.27cm;"><br></p>
                </td>
            </tr>
            <tr>
                <td bgcolor="#ffffff" style="background: #ffffff;border: 1px solid #999999;padding: 0.04cm 0cm;">
                    <ul>
                        <li>
                            <p style="line-height: 115%;padding: 0px 5px;text-align: justify;background: transparent;margin-bottom: 0cm;">Standard check-in timings of hotels are 12 pm and check-out is 11 am. Early check-in and late check-out will be available as per hotel availability and hotel rules.</p>
                        </li>
                        <li>
                            <p style="line-height: 115%;padding: 0px 5px;text-align: justify;background: transparent;margin-bottom: 0cm;">Car/driver details will be provided by the operator prior to travel start date.</p>
                        </li>
                        <li>
                            <p style="line-height: 115%;padding: 0px 5px;text-align: justify;background: transparent;margin-bottom: 0cm;">It is mandatory to carry a valid photo identity card for hotel stay (Passport/Driving License/Voter ID card/Aadhar card)</p>
                        </li>
                        <li>
                            <p style="line-height: 115%;padding: 0px 5px;text-align: justify;background: transparent;margin-bottom: 0.49cm;">Bookings will only be considered confirmed if first payment has been paid in WALKINTOTHEWILD account by any of the various modes provided on WALKINTOTHEWILD website. In all other cases, WALKINTOTHEWILD will not be liable for any bookings made.</p>
                        </li>
                    </ul>
                    <p style="line-height: 115%;padding: 0px 5px;text-align: justify;margin-bottom: 0.25cm;background: transparent;margin-left: 1.27cm;margin-top: 0.49cm;"><br></p>
                </td>
            </tr>
            <tr>
                <td bgcolor="#ffffff" style="background: #ffffff;border: 1px solid #999999;padding: 0.04cm 0cm;">
                    <ul>
                        <li>
                            <p style="line-height: 115%;padding: 0px 5px;text-align: justify;background: transparent;margin-bottom: 0cm;">In the event of a transport breakdown, customers will be required to wait for repairs or alternative arrangements. Due to the challenging terrain, such delays may occur. WALKINTOTHEWILD shall not be held liable for any losses or inconveniences arising from transport breakdowns.</p>
                        </li>
                        <li>
                            <p style="line-height: 115%;padding: 0px 5px;text-align: justify;background: transparent;margin-bottom: 0cm;">Inner Line permit are subject to government policies and office timings. WALKINTOTHEWILD shall not be liable for any changes made due to this.</p>
                        </li>
                        <li>
                            <p style="line-height: 115%;padding: 0px 5px;text-align: justify;background: transparent;margin-bottom: 0cm;">In case you have any persons of different nationalities (other than Indian) joining the tour, please mention their nationality before confirming booking. WALKINTOTHEWILD will not be responsible for any losses, in case of failure to do so.</p>
                        </li>
                        <li>
                            <p style="line-height: 115%;padding: 0px 5px;text-align: justify;background: transparent;margin-bottom: 0cm;">Air Conditioning in car will not be available in hilly areas unless mentioned in Inclusions.</p>
                        </li>
                        <li>
                            <p style="line-height: 115%;padding: 0px 5px;text-align: justify;margin-bottom: 0.25cm;background: transparent;">In case a hotel is non-operational, WALKINTOTHEWILD/operator reserves the right to change the hotel to next best option available.&nbsp;</p>
                        </li>
                    </ul>
                </td>
            </tr>
        </tbody>
    </table>

    <p>Best regards,</p>
    <p>Team Walk into the Wild
        <?php if (isset(\Yii::$app->params['environment'])) {
            echo \Yii::$app->params['environment'] != 'production' ?  \Yii::$app->params['environment'] : '';
        } ?>
    </p>
</div>