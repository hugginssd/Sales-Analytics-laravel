<?php
$router->group(['prefix' => 'cms_category'], function ($router) {
    $router->get('/', 'Modules\Cms\CmsCategoryController@index')->name('admin_cms_category.index');
    $router->get('create', 'Modules\Cms\CmsCategoryController@create')->name('admin_cms_category.create');
    $router->post('/create', 'Modules\Cms\CmsCategoryController@postCreate')->name('admin_cms_category.create');
    $router->get('/edit/{id}', 'Modules\Cms\CmsCategoryController@edit')->name('admin_cms_category.edit');
    $router->post('/edit/{id}', 'Modules\Cms\CmsCategoryController@postEdit')->name('admin_cms_category.edit');
    $router->post('/delete', 'Modules\Cms\CmsCategoryController@deleteList')->name('admin_cms_category.delete');
});
