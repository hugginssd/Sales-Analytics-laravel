<?php
$router->group(['prefix' => 'cms_content'], function ($router) {
    $router->get('/', 'Modules\Cms\CmsContentController@index')->name('admin_cms_content.index');
    $router->get('create', 'Modules\Cms\CmsContentController@create')->name('admin_cms_content.create');
    $router->post('/create', 'Modules\Cms\CmsContentController@postCreate')->name('admin_cms_content.create');
    $router->get('/edit/{id}', 'Modules\Cms\CmsContentController@edit')->name('admin_cms_content.edit');
    $router->post('/edit/{id}', 'Modules\Cms\CmsContentController@postEdit')->name('admin_cms_content.edit');
    $router->post('/delete', 'Modules\Cms\CmsContentController@deleteList')->name('admin_cms_content.delete');
});
