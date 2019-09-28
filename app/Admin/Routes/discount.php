<?php
$router->group(['prefix' => 'shop_discount'], function ($router) {
    $router->get('/', 'Extensions\Total\DiscountController@index')->name('admin_discount.index');
    $router->get('create', 'Extensions\Total\DiscountController@create')->name('admin_discount.create');
    $router->post('/create', 'Extensions\Total\DiscountController@postCreate')->name('admin_discount.create');
    $router->get('/edit/{id}', 'Extensions\Total\DiscountController@edit')->name('admin_discount.edit');
    $router->post('/edit/{id}', 'Extensions\Total\DiscountController@postEdit')->name('admin_discount.edit');
    $router->post('/delete', 'Extensions\Total\DiscountController@deleteList')->name('admin_discount.delete');
});
