<?php

Route::group(
    [
        'prefix'    => 'extension/discount',
        'namespace' => 'App\Extensions\Total\Providers',
    ], function () {
        Route::post('/useDiscount', 'DiscountService@useDiscount')->name('useDiscount');
        Route::post('/removeDiscount', 'DiscountService@removeDiscount')->name('removeDiscount');
    });
