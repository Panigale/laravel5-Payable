<?php
/**
 * Author: Panigale
 * Date: 2019-08-22
 * Time: 15:06
 */

return [

    // your store name.
    'allPay' => [
        'hashKey' => env('ALLPAY_HASHKEY'),

        // Provide from AllPay hashIV
        'hashIV'  => env('ALLPAY_HASHIV'),

        'merchantId' => env('ALLPAY_MERCHANTID'),

        'title' => env('ALLPAY_TITLE')
    ],
];