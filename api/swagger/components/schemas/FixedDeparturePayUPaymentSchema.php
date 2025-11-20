<?php

namespace api\swagger\components\schemas;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="FixedDeparturePayUPaymentSchema",
 *     type="object",
 *     @OA\Property(
 *         property="payu",
 *         type="object",
 *         @OA\Property(property="key", type="string", example="3RYMv6"),
 *         @OA\Property(property="txnid", type="string", example="t251119183047809"),
 *         @OA\Property(property="amount", type="number", example=46000),
 *         @OA\Property(property="productinfo", type="string", example="Safari Booking Payment"),
 *         @OA\Property(property="firstname", type="string", example="Vivek Bharti"),
 *         @OA\Property(property="email", type="string", example="vivek@triline.co.in"),
 *         @OA\Property(property="phone", type="string", example="9211635325"),
 *         @OA\Property(property="surl", type="string", example="https://staging-webhook.walkintothewild.in/payu-response"),
 *         @OA\Property(property="furl", type="string", example="https://staging-webhook.walkintothewild.in/payu-response"),
 *         @OA\Property(property="udf1", type="string", example="RFD-691dbf7fee04b-2511-1763557247-809"),
 *         @OA\Property(property="udf2", type="string", example="OFD-691dbf7fee054-2511-1763557247-809"),
 *         @OA\Property(property="udf3", type="string", example=""),
 *         @OA\Property(property="udf4", type="string", example=""),
 *         @OA\Property(property="udf5", type="string", example=""),
 *         @OA\Property(property="udf6", type="string", example=""),
 *         @OA\Property(property="udf7", type="string", example=""),
 *         @OA\Property(property="udf8", type="string", example=""),
 *         @OA\Property(property="udf9", type="string", example=""),
 *         @OA\Property(property="udf10", type="string", example=""),
 *         @OA\Property(property="hash", type="string", example="f96022bd20881bdba9fba7a55a9dc446331585d851cd074b906acbdebcbb6764aefdaf274d6910c26d1462702bb9582db201a261705ab7423975e1b83a965242"),
 *         @OA\Property(property="quickPayEvent", type="string", example="f96022bd20881bdba9fba7a55a9dc446331585d851cd074b906acbdebcbb6764aefdaf274d6910c26d1462702bb9582db201a261705ab7423975e1b83a965242"),
 *         @OA\Property(property="getSdkConfiguration", type="string", example="a38d6384e497d19ae3df5f2f048020291f01f1b80c7b61f004c85beca23b284f71b7ed597e92a9d5603cee3c90159b93426185f5f9da65b62cf2df7c22242b41"),
 *         @OA\Property(property="getCheckoutDetails", type="string", example="09864b5e568d15fbc9bc0e4887b45a0172fb18563cc7e2036f48a256a01998f0490f046f59d22c7602d407dbf3a39cfacb6a38fe2a527290132beabc5c9bbd8c"),
 *         @OA\Property(property="getAllOfferDetails", type="string", example="8ea6952bc20cef2842a68228cb6c6b02441470f6699b5d7d66125eeaae05601e3605efa8bcde55185833aafd1f331f5fb1058ae64b16cfa78df04e79393cf0a8")
 *     ),
 *     @OA\Property(property="payu_transaction_url", type="string", example="https://test.payu.in/_payment"),
 *     @OA\Property(property="status", type="integer", example=1)
 * )
 */
class FixedDeparturePayUPaymentSchema {}