<?php

Route::group(
    [
        'prefix'    => 'extension/payment',
        'namespace' => 'App\Extensions\Payment\Providers',
    ], function () {
        Route::get('paypal', 'PayPalService@index')->name('paypal');
        Route::get('return/{order_id}', 'PayPalService@getReturn')->name('returnPaypal');
    });
