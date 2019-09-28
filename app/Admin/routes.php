<?php
use Illuminate\Routing\Router;
Route::group([
    'middleware' => ['web', 'admin', 'localization'],
    'namespace' => 'App\Admin\Controllers',
    'prefix' => config('app.admin_prefix'),
], function (Router $router) {
    foreach (glob(__DIR__ . '/Routes/*.php') as $filename) {
        require_once $filename;
    }
    $router->get('/', 'HomeController@index')->name('admin.home');
    $router->get('deny', 'HomeController@deny')->name('admin.deny');

    //Language
    $router->get('locale/{code}', function ($code) {
        session(['locale' => $code]);
        return back();
    })->name('admin.locale');

});
